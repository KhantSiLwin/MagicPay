@extends('backend.layouts.app')

@section('title')
    Wallet
@endsection

@section('wallet')
    mm-active
@endsection

@section('icon')
wallet 
@endsection

@section('content')


      <div class="py-3">
        <div class="card">
            <div class="card-body">
               <table class="table table-hover table-striped datatable">
                   <thead>
                      <tr class="bg-lights">
                          <th>Account Amount</th>
                          <th>Owner</th>
                          <th>Amount(MMK)</th>
                          <th>Created At</th>
                          <th>Updated At</th>
                      </tr>
                   </thead>
                   <tbody>
                     
                   </tbody>
               </table>
            </div>
        </div>
      </div>
@endsection

@section('js')
    
      <script>

            $(document).ready(function(){
              let table =  $('.datatable').DataTable({
                    
                    processing : true,
                    serverSide : true,
                    ajax       : "wallet/datatables/ssd",
                    columns: [
                        {
                            data : 'account_number',
                            name : 'account_number'
                        },

                        {
                            data : 'owner',
                            name : 'owner'
                        },

                        {
                            data : 'amount',
                            name : 'amount'
                        },

                        {
                            data : 'created_at',
                            name : 'created_at',
                        },

                        {
                            data : 'updated_at',
                            name : 'updated_at',
                        },

                    ],
                    order:[
                        [4,"desc"]
                    ]

                });

              
            });

      </script>

@endsection