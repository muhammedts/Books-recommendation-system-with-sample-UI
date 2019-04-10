@extends('layouts.app')
@section('content')

<div class="col-lg-9">
        <script>
                $(document).ready(function(){
                //alart('teass');
                  fetch_customer_data();

                      function fetch_customer_data(query = ''){
                          $.ajax({
                              url:"{{ route('liveSearch.action') }}",
                              method:'GET',
                              data:{query:query},
                              dataType:'json',
                              success:function(data){
                                  $('.row').html(data.table_data);
                                  $('#total_records').text(data.total_data);
                              }
                          })
                      }
                  $('#search').on('keyup', function(){
                      //alart('tess');
                      var query = $(this).val();
                      fetch_customer_data(query);
                      });
                  });
            </Script>
              <!--added new-->
        <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Search with title or author" />
          </div>

          <div class="table-responsive">
          <h3 alig="center">Total Data : <span id="total_records"></span></h3>
          <!--neeew-->

                <div class="row">

                </div>

            </div>

        {{$books->links()}}
</div>
@endsection
