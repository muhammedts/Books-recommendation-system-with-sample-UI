@extends('layouts.app')
@section('content')
<!--
  <div class="row">

    <div class="col-lg-3">
      
      <h1 class="my-4">Read now..</h1>
              <!--
              <div class="list-group">
                <a href="#" class="list-group-item">Category 1</a>
                <a href="#" class="list-group-item">Category 2</a>
                <a href="#" class="list-group-item">Category 3</a>
              </div>
              -->
      <!--
    </div>
            <!-- /.col-lg-3 -->
     <!-- 
    <div class="col-lg-9">
      
              <!--
              <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
                -->

              <!--added new-->
        <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Search with title or author" />
          </div>
         
          <div class="table-responsive">
          <h3 alig="center">Total Data : <span id="total_records"></span></h3>
          <!--neeew-->

        <!-- foreach loop  
              <div class="row">
      
                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="card h-100">
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">
                      <h4 class="card-title">
                        <a href="#">Item One</a>
                      </h4>
                      <h5>$24.99</h5>
                      <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                    </div>
                    <div class="card-footer">
                      <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                  </div>
                </div>
      -->

      <div class="row">
            
            </div>
      
            </div>
            {{$books->links()}}
          </div>
            <br>
            <!-- /.row -->
          </div>
     <!--  </div><!-- /.row -->
      <!-- /.col-lg-9 -->
   <!-- </div>
   -->
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
@endsection
