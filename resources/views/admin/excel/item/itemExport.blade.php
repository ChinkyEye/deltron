<p>Item Report</p>
<table>
  <thead class="table-primary">                  
    <tr>
      <th>SN</th>
      <th>Category</th>
      <th>Item</th>
      <th>Qty</th>
      <th>Unit</th>
    </tr>
  </thead>
  <tbody>
      @foreach($orders as $index=>$order)
    <tr>
      <td>{{$index+1}}</td>
      <td>{{$order->item->category->name}}</td>
      <td>{{$order->item->name}}</td>
      <td>{{$order->sumqty}}</td>
      <td>{{$order->unit->name}}</td>
    </tr>
      @endforeach
  </tbody>
</table>