<?php

// app/Http/Controllers/InvitationController.php

namespace App\Http\Controllers;
use App\Invitation;
use Illuminate\Support\Str;

use App\BusinessLocation;
use App\User;
use App\Utils\ModuleUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Events\UserCreatedOrModified;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SnapshotMail;

class InvitationController extends Controller
{
    public function create($event_id)
    {
        return view('invitations.create')->with(compact('event_id'));
    }

    public function store(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(32);
        $expiryDate = now()->addDays(7); // Adjust the expiration period as needed
        // check if email already exists in users table and in invitations table with status used
        $user = User::where('email', $request->email)->where('business_id',$business_id)->first();
        if($user){
            return redirect()->back()->with('status', ['success'=>0,'msg'=>'User already exists!']);
        }
        // $invitation = Invitation::where('email', $request->email)->where('status', 'used')->first();
        
        $invitation = Invitation::create([
            'business_id' => $business_id,
            'event_id' => ($request->has('event_id'))?$request->event_id:null,
            'email' => $request->email,
            'token' => $token,
            'invitation_link' => route('invitations.accept', ['token' => $token]),
            'expiry_date' => $expiryDate,
        ]);

        // Send an email with the invitation link (use your email sending logic here)
        // Send an email with the invitation link
        $emailData = [
            'invitation' => $invitation,
            'invitationLink' => route('invitations.accept', ['token' => $invitation->token]),
        ];


        $to = "$request->email";
        $subject = "Invitation to join as Collaborator";
        $acceptLink = route('invitations.accept', ['token' => $invitation->token]);
        // dd($acceptLink);
        $header_content = 'Join our business ' . session()->get('business.name') . ' as a collaborator';
        $body_content = " <p>Hello,</p>
                        <p>You have been invited to join as a collaborator photographer. We believe your skills and talent will be a great addition to our team.</p>
                        <p>Please accept the invitation by clicking the link below:</p>
                        <p><a href='{$acceptLink}' target='_blank'>Accept Invitation</a></p>
                        <p>If the button above doesn't work, you can also copy and paste the following URL into your browser:</p>
                        <p>{$acceptLink}</p>";
        $mail = new SnapshotMail($subject, $header_content, $body_content);
        Mail::to($request->email)->bcc('malikshahzar2@gmail.com')->send($mail);

        
        // Mail::to($request->email)->send(new InvitationEmail($emailData));
        return redirect()->back()->with('status', ['success'=>1,'msg'=>'Invitation sent successfully!']);
    }
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation || $invitation->status === 'used' || $invitation->expiry_date < now()) {
            return abort(404);
        }

        $business_id = $invitation->business_id;


        $roles = $this->getRolesArray($business_id);
        // dd($roles);
        // find the key where value is collaborator in $roles array
        $role_id = array_search('Collaborator', $roles);
        
        $username_ext ='';
        $locations = BusinessLocation::where('business_id', $business_id)
                                    ->Active()
                                    ->get();

        //Get user form part from modules
        $form_partials = [];
        $is_invitation = true;
        return view('manage_user.create_invited')
                ->with(compact('roles', 'username_ext', 'locations', 'form_partials','invitation','is_invitation','role_id'));

        // Your logic for handling user registration with the given role

        // $invitation->update(['status' => 'used']);

        // return redirect()->route('login')->with('success', 'Invitation accepted! You can now log in.');
    } /**
     * Retrives roles array (Hides admin role from non admin users)
     *
     * @param  int  $business_id
     * @return array $roles
     */
    private function getRolesArray($business_id)
    {
        $roles_array = Role::where('business_id', $business_id)->get()->pluck('name', 'id');
        $roles = [];

        $is_admin = false;

        foreach ($roles_array as $key => $value) {
            if (! $is_admin && $value == 'Admin#'.$business_id) {
                continue;
            }
            $roles[$key] = str_replace('#'.$business_id, '', $value);
        }

        return $roles;
    }


}

