<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report of  Purchase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div>
      <h1 class="text-center">{{$title->name}},{{$title->address}}</h1>
      <h3 class="text-center">Purchase Report({{$start_date}} / {{$end_date}})</h3>
      <h6>{{ date('Y') }}</h6>
    </div>
    <div class="row">
      <div class="table-responsive col-md">
        <table class="table table-bordered table-hover table-sm m-0">
          <thead class="table-primary">                  
            <tr>
              <th>SN</th>
              <th>Supplier Name</th>
              <th>Item Name</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($purchasereports as $index => $data)
            <tr>
              <td>{{$index+1}}</td>
              <td>{{$data->supplier_name}}</td>
              <td>{{$data->item_name}}</td>
              <td>{{$data->description}}</td>
              <td>{{$data->amount}}</td>
              <td>{{$data->date_np}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>