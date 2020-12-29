<div id="print-area">
    <table class="table table-hover table-bordered">
    {{__('site.clients_name') . ' : ' . $order->clients->name}}<br>
        {{__('site.clients_address') . ' : ' . $order->clients->address}}<br>
        {{__('site.clients_mobile').' : '}}{{ is_array($order->clients->mobile) ? implode($order->clients ->mobile,'-') : $order->clients->mobile }}
        <thead>
        <tr>
            <th>@lang('site.product_name')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.sale_price')</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>@lang('site.total') <span>{{ number_format($order->total_price , 2) }}</span></h3>
      
</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>