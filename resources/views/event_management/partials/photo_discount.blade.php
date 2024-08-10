<div class="pos-tab-content">
    <div class="row">
        @component('components.widget', [
            'class' => 'box-primary',
            'title' => 'Manage event discount',
        ])
        {!! Form::open([
            'url' => action([\App\Http\Controllers\EventManagementController::class, 'storePhotoDiscountSetting']),
            'method' => 'post',
            'id' => 'photo_discount_setting_form',
        ]) !!}
        <input type="hidden" name="discount_id"
            value="{{ isset($photoDiscountSetting) ? $photoDiscountSetting->id : null }}">
        <div class="modal-body">
            <!-- Discount Type -->
            <div class="form-group">
                {!! Form::label('discount_type', 'Discount Type:*') !!}
                {!! Form::select(
                    'discount_type',
                    ['percentage' => 'Percentage Discount', 'selfie_bundle' => 'Selfie Bundle'],
                    isset($photoDiscountSetting) ? $photoDiscountSetting->discount_type : null,
                    ['class' => 'form-control'],
                ) !!}
            </div>

            <!-- X Photos (for Percentage Discount) -->
            <div class="form-group" id="x_photos_container">
                {!! Form::label('x_photos', 'X Photos:*') !!}
                {!! Form::number('x_photos', isset($photoDiscountSetting) ? $photoDiscountSetting->x_photos : null, [
                    'class' => 'form-control',
                    'min' => 1,
                ]) !!}
            </div>

            <!-- Percentage Discount -->
            <div class="form-group" id="percentage_discount_container">
                {!! Form::label('percentage_discount', 'Percentage Discount:*') !!}
                {!! Form::number(
                    'percentage_discount',
                    isset($photoDiscountSetting) ? $photoDiscountSetting->percentage_discount : null,
                    ['class' => 'form-control', 'min' => 1],
                ) !!}
            </div>

            <!-- Total Amount (for Selfie Bundle) -->
            <div class="form-group" id="total_amount_container">
                {!! Form::label('total_amount', 'Total Amount:*') !!}
                {!! Form::number('total_amount', isset($photoDiscountSetting) ? $photoDiscountSetting->total_amount : null, [
                    'class' => 'form-control',
                    'min' => 1,
                ]) !!}
            </div>

            <!-- Discount Start Date -->
            <div class="form-group">
                {!! Form::label('discount_start_date', 'Discount Start Date:*') !!}
                {!! Form::text(
                    'discount_start_date',
                    isset($photoDiscountSetting) ? $photoDiscountSetting->discount_start_date : null,
                    ['class' => 'form-control datepicker'],
                ) !!}
            </div>

            <!-- Discount End Date -->
            <div class="form-group">
                {!! Form::label('discount_end_date', 'Discount End Date:*') !!}
                {!! Form::text(
                    'discount_end_date',
                    isset($photoDiscountSetting) ? $photoDiscountSetting->discount_end_date : null,
                    ['class' => 'form-control datepicker'],
                ) !!}
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit"
                class="btn btn-primary">{{ isset($photoDiscountSetting) ? 'Update' : 'Save' }}</button>
            <a type="button" class="btn btn-default"
                href="{{ action([\App\Http\Controllers\EventManagementController::class, 'index']) }}">Back</a>
        </div>

        {!! Form::close() !!}

        @endcomponent

    </div>
</div>


