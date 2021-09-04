@extends('backend.layouts.app')

@section('title')
    Users
@endsection

@section('user')
    mm-active
@endsection

@section('icon')
users 
@endsection

@section('content')

    <div class="pt-3">
        <a href="{{route('admin.user.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle">Create User</i></a>
    </div>

      <div class="py-3">
        <div class="card">
            <div class="card-body">
               <table class="table table-hover table-striped datatable">
                   <thead>
                      <tr class="bg-lights">
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>IP</th>
                          <th>User Agent</th>
                          <th>Login At</th>
                          <th>Created At</th>
                          <th>Updated At</th>
                          <th>Action</th>
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
                    ajax       : "user/datatables/ssd",
                    columns: [
                        {
                            data : 'name',
                            name : 'name'
                        },

                        {
                            data : 'email',
                            name : 'email'
                        },

                        {
                            data : 'phone',
                            name : 'phone',
                            sortable: 'false'
                        },

                        {
                            data : 'ip',
                            name : 'ip'
                        },

                        {
                            data : 'user_agent',
                            name : 'user_agent',
                            searchable: 'false',
                            sortable: 'false'
                        },

                        {
                            data : 'login_at',
                            name : 'login_at',
                        },

                        {
                            data : 'created_at',
                            name : 'created_at',
                        },

                        {
                            data : 'updated_at',
                            name : 'updated_at',
                        },

                        {
                            data : 'action',
                            name : 'action',
                            searchable: 'false',
                            sortable: 'false'
                        },
                    ],
                    order:[
                        [5,"desc"]
                    ]

                });

               
                    $(document).on('click','.delete',function(e){

                        e.preventDefault();
                        let id  = $(this).data('id');

                        Swal.fire({
                        title: 'Are you sure?',
                        showCancelButton: true,
                        confirmButtonText: `Confirm`,
                        }).then((result) => {

                        if (result.isConfirmed) {
                            $.ajax({
                                url : '@php
                                    $url
                                @endphp./user/'+ id,
                                type: 'DELETE',
                                success: function(){
                                    table.ajax.reload();
                                }
                            })
                        }

                        })
                })
            })

      </script>

@endsection