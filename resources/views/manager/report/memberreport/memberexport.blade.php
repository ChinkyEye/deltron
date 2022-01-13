<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report of  Member</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div>
      <p class="text-center">{{$title->name}},{{$title->address}}</p>
      <p class="text-center">Member Report</p>
      <p>{{$scheme_name}},{{$agent_name}},{{ date('Y') }}</p>

    </div>
    <table class="table table-bordered table-hover table-sm m-0">
    <thead>
      <tr class="table-primary">
        <td class="text-bold">Sn Me</td>
        <td>Member Name</td>
        <td>Address</td>
        <td>Phone no.</td>
        <td>Agent Name</td>
        <td>SN</td>
        @foreach($kista_name as $value)
        <td>{{$value}}</td>
        @endforeach
      </tr>
      </thead>
      <tbody>
        @foreach ($posts as $data)
        <tr>
            <td>{{ $data->serial_no}}</td>
            <td>{{ $data->name}}</td>
            <td>{{ $data->address }}</td>
            <td>{{ $data->phone }}</td>
            <td>{{ $data->getAgent->name }}</td>
            @if($data->getCount)
              @if($data->getCount->total == null)
              <td>1</td>
              @elseif($data->getCount->total == 1)
              <td>2</td>
              @elseif($data->getCount->total == 2)
              <td>3</td>
              @else
              <td></td>
              @endif
            @else
            <td>1</td>
            @endif
            @foreach($data->getClientDetail as $value)
            <td>{{$value->amount}}</td>
            @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>