<div>
    <h3 class="card-title">Activity Log</h3>
    <div class="table-responsive">
        <!-- id="zero_configuration_table"  -->
        <table class="display table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Admin Name</th>
                    <th scope="col">Activity</th>
                    <th scope="col">Type</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($activities as $key => $activity)
                <tr>
                    <th scope="col">{{$key+1}}</th>
                    <th scope="col">{{$activity->admin_name}}</th>
                    <th scope="col">{{$activity->activity}}</th>
                    <th scope="col">
                        @if($activity->type == 'meptp')
                        Tiered PPMV Registration
                        @endif
                        @if($activity->type == 'ppmv')
                        Tiered PPMV Registration
                        @endif
                    </th>
                    <th scope="col">{{$activity->created_at->format('d/M/Y')}}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>