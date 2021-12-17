<p>Asset Report</p>
<table>
  <thead class="table-primary">                  
    <tr>
      <th>SN</th>
      <th>Category</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>VAT</th>
      <th>Rate</th>
      <th>Total</th>
      <th>Unit</th>
      <th>From</th>
      <th>Issued</th>
    </tr>
  </thead>
  <tbody>
      @foreach($assets as $index=>$asset)
    <tr>
      <td>{{$index+1}}</td>
      <td>{{$asset->category->name}}</td>
      <td>{{$asset->name}}</td>
      <td>{{$asset->price}}</td>
      <td>{{$asset->quantity}}</td>
      <td>{{$asset->vat}}</td>
      <td>{{$asset->rate}}</td>
      <td>{{$asset->total}}</td>
      <td>{{$asset->unit->name}}</td>
      <td>{{$asset->bought->name}} {{$asset->bought->user_code}}</td>
      <td>{{$asset->created_at}}</td>
    </tr>
      @endforeach
  </tbody>
</table>