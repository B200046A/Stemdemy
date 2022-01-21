@include('header',['Title'=>"Edit Class Page"])
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row mt-5">
    <div class="col-md-10 offset-md-1">
        <h3 class="text-center mb-4">Drag and Drop Datatables Using jQuery UI Sortable - Demo </h3>
        <form enctype="multipart/form-data" action="{{ route('post-sortable')}}" method="post">
        @csrf
        <table id="table" class="table table-bordered">
          <thead>
            <tr>
              <th width="30px">#</th>
              <th>Course Name</th>
              <th>Course Info</th>
              <th>Current Video</th>
              <th>Replace Video As</th>
            </tr>
          </thead>
          <tbody id="tablecontents">
            @foreach($CourseInfo as $course)
                <tr class="row1" data-id="{{ $course->id }}">
                    <td>{{$course->doc_order}}</td>
                    <td><input type="text" class="form-control" name="courseName[{{ $course->id }}]" value="{{$course->name}}"></td>
                    <td><input type="text" class="form-control" name="courseInfo[{{ $course->id }}]" value="{{$course->info}}"></td>
                    <td class="text-center"><a href="http://media.w3.org/2010/05/sintel/trailer.mp4" target="_blank"><button>View Video</button></a></td>
                    <td><input type="file" accept="image/*" class="form-control" name="docFile[{{ $course->id }}]"></td>
                </tr>
            @endforeach
          </tbody>                  
        </table>
        <button class="w-25 btn btn-lg btn-primary mt-3" type="submit">Register</button>
    </form>
        <hr>
        <h5>Drag and Drop the table rows and <button class="btn btn-success btn-sm" onclick="window.location.reload()">REFRESH</button> the page to check the Demo.</h5> 
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("#table").DataTable();

    $( "#tablecontents" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {
      var order = [];
      var token = $('meta[name="csrf-token"]').attr('content');
      console.log($(this).find("td:eq(0) input[type='text']").val());

      $('tr.row1').each(function(index,element) {
            order.push({
            id: $(this).attr('data-id'),
            position: index+1
            });
      });

    //   $.ajax({
    //     type: "POST", 
    //     dataType: "json", 
    //     url: "{{ url('post-sortable') }}",
    //         data: {
    //       order: order,
    //       _token: token
    //     },
    //     success: function(response) {
    //         if (response.status == "success") {
    //           console.log(response);
    //         } else {
    //           console.log(response);
    //         }
    //     }
    //   });
    }
  });
</script>