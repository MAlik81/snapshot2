<?php

namespace App\Http\Controllers;

use App\Eventalbums;
use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Withdrawals;
use App\PhotosSalesRecord;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Mail;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Entities\Package;
use App\EventAlbumPhotos;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\Exception\ApiErrorException;
use App\Mail\SnapshotMail;


class WithdrawalController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // dd(session()->get('business'));
        $business_id = session()->get('user.business_id');
        $withdrawns = array();       
        $withdrawns = Withdrawals::where('business_id', $business_id)->get();
        $total_withdrawn = Withdrawals::where('business_id', $business_id)->where('status', 'approved')->sum('requested_amount');
        $pending_withdrawals = Withdrawals::where('business_id', $business_id)->where('status', 'pending')->sum('requested_amount');
        $total_amount = PhotosSalesRecord::where('business_id', $business_id)->sum('vendor_share');
        return view('withdrawals.index', compact('withdrawns','total_withdrawn','pending_withdrawals','total_amount'));
    }

    // Show the form for creating a new resource.
    public function requestCreate(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $withdrawns = array();       
        $withdrawns = Withdrawals::where('business_id', $business_id)->get();
        $total_withdrawn = Withdrawals::where('business_id', $business_id)->where('status', 'approved')->sum('requested_amount');
        $pending_withdrawals = Withdrawals::where('business_id', $business_id)->where('status', 'pending')->sum('requested_amount');
        $total_amount = PhotosSalesRecord::where('business_id', $business_id)->sum('vendor_share');
        $available_amount = $total_amount-$total_withdrawn-$pending_withdrawals;
        return view('withdrawals.vendor_create_request', compact('withdrawns','total_withdrawn','pending_withdrawals','total_amount','available_amount'));
    }
    // Show the form for creating a new resource.
    public function requestStore(Request $request)
    {
        $business_id = session()->get('user.business_id');
        $withdrawns = array();       
        $withdrawns = Withdrawals::where('business_id', $business_id)->get();
        $total_withdrawn = Withdrawals::where('business_id', $business_id)->where('status', 'approved')->sum('requested_amount');
        $pending_withdrawals = Withdrawals::where('business_id', $business_id)->where('status', 'pending')->sum('requested_amount');
        $total_amount = PhotosSalesRecord::where('business_id', $business_id)->sum('vendor_share');
        $available_amount = $total_amount-$total_withdrawn-$pending_withdrawals;
        
        $admin_email = User::find(1)->email;
        try {
            if($request->input('requested_amount') > $available_amount){
                return redirect('/withdrawals')->with('status', ['success' => 0, 'msg' => 'Requested amount is greater than available amount!']);
            }
            $withdraw = new Withdrawals;
            $withdraw->business_id = $business_id;
            $withdraw->requested_amount = $request->input('requested_amount');
            $withdraw->status = 'pending';
            $withdraw->save();

            $header_content = 'Withdrawal Request from ' . session()->get('business.name');
            $body_content = '<b>Requested Amount:</b> $' . $request->input('requested_amount') . '<br>';
            $body_content .= '<b>Status: Pending <br>';
            $body_content .= '<b>Requested Date:</b> ' . date('Y-m-d H:i:s') . '<br>';
            $body_content .= '<b>Available Amount:</b> $' . $pending_withdrawals;
            $subject = 'Withdrawal Request';
            $mail = new SnapshotMail($subject, $header_content, $body_content);
            Mail::to($admin_email)->bcc('malikshahzar2@gmail.com')->send($mail);

            return redirect('/withdrawals')->with('status', ['success' => 1, 'msg' => 'Withdrawal request sent successfully!']);
        } catch (\Exception $e) {
            return redirect('/withdrawals')->with('status', ['success' => 0, 'msg' => 'Failed to send withdrawal request!']);
        }
    }
    
    public function withdrawlRequests()
    {
        $business_id = session()->get('user.business_id');
        $total_platform_sales = PhotosSalesRecord::sum('net_amount');
        $total_platform_share =  PhotosSalesRecord::sum('platform_share');
        $total_vendors_share =  PhotosSalesRecord::sum('vendor_share');
        $withdrawns = array();       
        $withdrawns = Withdrawals::join('business', 'vendor_withdrawals.business_id', '=', 'business.id')
        ->select('vendor_withdrawals.*', 'business.name as business_name')->get();
        $total_withdrawn = Withdrawals::where('status', 'approved')->sum('requested_amount');
        $pending_withdrawals = Withdrawals::where('status', 'pending')->sum('requested_amount');
        return view('withdrawals.superadmin_view', compact('withdrawns','total_withdrawn','pending_withdrawals','total_platform_sales','total_platform_share','total_vendors_share'));
    }

    // Show the form for creating a new resource.
    public function sendRequestedWithdraw(Request $request)
    {
        return view('withdrawals.superadmin_view');
    }
    
    public function decline(Request $request)
    {
        if($request->ajax()){
            $withdraw = Withdrawals::where('id',$request->input('id'))
            ->where('status','pending')
            ->join('business', 'vendor_withdrawals.business_id', '=', 'business.id')
            ->join('users', 'business.owner_id', '=', 'users.id')
            ->select('vendor_withdrawals.*', 'business.name as business_name', 'users.email as owner_email')->first();
            $owner_email = $withdraw->owner_email;
            // dd($business_email);
            $reason = $request->input('reason');
            $withdraw->status = 'declined';
            $withdraw->decline_reason = $reason;
            if($withdraw->save()){
                $header_content = 'Your withdrawal request has been declined by ' . session()->get('business.name');
                $body_content = '<b>Reason:</b> ' . $reason . '<br>';
                $body_content .= '<b>Status:</b> Declined <br>';
                $body_content .= '<b>Decline Date:</b> ' . date('Y-m-d H:i:s') . '<br>';
                $body_content .= '<b>Requested Amount:</b> $' . $withdraw->requested_amount;
                $subject = 'Withdrawal Request Declined';
                $mail = new SnapshotMail($subject, $header_content, $body_content);
                Mail::to($owner_email)->bcc('malikshahzar2@gmail.com')->send($mail);
                return response()->json(['success' => 1, 'msg' => 'Withdrawal request declined successfully!']);
            } else {
                return response()->json(['success' => 0, 'msg' => 'Failed to decline withdrawal request!']);
            }
        }
        abort(404);
    }
    public function approve(Request $request)
    {
        if($request->ajax()){
            $withdraw = Withdrawals::where('id',$request->input('id'))
            ->where('status','pending')
            ->join('business', 'vendor_withdrawals.business_id', '=', 'business.id')
            ->join('users', 'business.owner_id', '=', 'users.id')
            ->select('vendor_withdrawals.*', 'business.name as business_name', 'users.email as owner_email')->first();
            $owner_email = $withdraw->owner_email;
            $proof_path = NULL;
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $directory = public_path('uploads/proofs');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $directory = public_path('uploads/proofs');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $proof_path = $file->move($directory, $file->getClientOriginalName());
            }
            $withdraw->status = 'approved';
            $withdraw->approval_date = date('Y-m-d H:i:s');
            $withdraw->proof_path = $proof_path;
            if($withdraw->save()){
                $header_content = 'Your withdrawal request has been approved by ' . session()->get('business.name');
                $body_content = '<b>Status:</b> Approved' . '<br>';
                $body_content .= '<b>Approval Date:</b> ' . date('Y-m-d H:i:s') . '<br>';
                $body_content .= '<b>Requested Amount:</b> $' . $withdraw->requested_amount;
                $body_content .= 'Proof: <a href="' . url('uploads/proofs/' . $file->getClientOriginalName()) . '">Download Proof</a>';
                $subject = 'Withdrawal Request Approved';
                $mail = new SnapshotMail($subject, $header_content, $body_content);
                Mail::to($owner_email)->bcc('malikshahzar2@gmail.com')->send($mail);

                return response()->json(['success' => 1, 'msg' => 'Withdrawal request approved successfully!']);
            } else {
                return response()->json(['success' => 0, 'msg' => 'Failed to approve withdrawal request!']);
            }
        }
        abort(404);
    }


    
}

