<div class="pos-tab-content">
    <div class="row">
        @if ($event_collaborator->user_type == 'get_what_you_sell_member')
          
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'Commission Details',
            ])
                <div class="card">

                    <div class="card-body" style="overflow: auto;">
                        
                                @foreach ($event_get_what_you_sell_member as $key => $user)
                                    @if ($user->user_id == Auth::user()->id)
                                    
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                                            <div class="info-box info-box-new-style">
                                                <span class="info-box-icon bg-navy">
                                                    <i class="fa fas fa-share"></i>
                        
                                                </span>
                        
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Commission percentage</span>
                                                    <span class="info-box-number">{{ 100 - $user->commission }}%</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                                            <div class="info-box info-box-new-style">
                                                <span class="info-box-icon bg-green">
                                                    <i class="fa fas fa-money-bill"></i>
                        
                                                </span>
                        
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Your share in sales</span>
                                                    <span class="info-box-number">${{ round(($user->collaborator_profit ?? 0),2) }}</span>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                        
                                        <!-- /.col -->
                                    </div>
                                    @endif
                                @endforeach
                            
                    </div>
                </div>
            @endcomponent
        </div>
          
        @endif
        @if ($event_collaborator->user_type == 'commission_based_member')
        <div class="col-md-12">
            @component('components.widget', [
                'class' => 'box-primary col-md-6',
                'title' => 'My Commission Details',
            ])
                <div class="card">

                    <div class="card-body" style="overflow: auto;">
                        
                                @foreach ($event_commission_based_member as $key => $user)
                                @if ($user->user_id == Auth::user()->id)
                                    
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                                        <div class="info-box info-box-new-style">
                                            <span class="info-box-icon bg-navy">
                                                <i class="fa fas fa-share"></i>
                    
                                            </span>
                    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Commission percentage</span>
                                                <span class="info-box-number">{{ $user->commission }}%</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12  col-custom">
                                        <div class="info-box info-box-new-style">
                                            <span class="info-box-icon bg-green">
                                                <i class="fa fas fa-money-bill"></i>
                    
                                            </span>
                    
                                            <div class="info-box-content">
                                                <span class="info-box-text">Your share in sales</span>
                                                <span class="info-box-number">${{ round(($user->collaborator_profit ?? 0),2) }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                    
                                    <!-- /.col -->
                                </div>
                                @endif
                                @endforeach
                           
                    </div>
                </div>
            @endcomponent
        </div>
        @endif
    </div>

</div>
