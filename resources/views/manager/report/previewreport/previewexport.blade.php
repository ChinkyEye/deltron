<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report of  MonthlyPurchase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div>
      <h1 class="text-center">{{$title}}</h1>
      <h3 class="text-center">Serial Number Report</h3>
      <h6>{{ date('Y') }}</h6>
    </div>
    {{-- <div class="card-body">
      <div class="row col-md">
        <div class="table-responsive col-md">
          <table class="table table-bordered table-hover table-sm m-0">
            <thead class="table-primary">                  
              <tr>
                <th>Member Name</th>
                <th>Used serial no</th>
                <th>Booked Serial no</th>
                <th>Available Serial no</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td colspan="2" style="visibility:collapse;"></td>
                <td rowspan="30" style="vertical-align:top;margin-top: 100px;" >
                  @foreach($booking_array as $deta)
                  {{$deta}},
                  @endforeach
                </td>
                <td rowspan="30" style="vertical-align:top">
                  @foreach($array as $detail)
                  {{$detail}},
                  @endforeach
                </td>
              </tr>
            </tfoot>
            <tbody>
              @foreach($previewreports as $data)
              <tr>
                <td>{{$data->name}}</td>
                <td>{{$data->serial_no}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div> --}}
    <div class="row">
      <div class="table-responsive col-md">
        <table class="table table-bordered table-hover table-sm m-0">
          <thead class="table-primary">                  
            <tr>
              <th>SN</th>
              <th>Member Name</th>
              <th>Used Serial No:</th>
            </tr>
          </thead>
          <tbody>
            @foreach($previewreports as $index => $data)
            <tr>
              <td>{{$index+1}}</td>
              <td>{{$data->name}}</td>
              <td>{{$data->serial_no}}</td>
            </tr>
            @endforeach
          </tbody>
          {{-- <tfoot>
            <tr>
              <td><strong>Total count: {{$total}}</strong></td>
            </tr>
          </tfoot> --}}
        </table>
      </div>
     {{--  <div class="table-responsive col-md">
        <table class="table table-bordered table-hover table-sm m-0">
          <thead class="table-primary">                  
            <tr>
              <th>Booked Serial no</th>
            </tr>
          </thead>
          <tbody class="bg-warning">
            @foreach($booking_array as $deta)
            <tr>
              <td>{{$deta}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="table-responsive col-md">
        <table class="table table-bordered table-hover table-sm m-0">
          <thead class="table-primary">                  
            <tr>
              <th>Available Serial no</th>
            </tr>
          </thead>
          <tbody class="bg-primary">
            @foreach($array as $detail)
            <tr>
              <td>{{$detail}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div> --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>