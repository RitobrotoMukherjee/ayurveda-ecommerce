@extends('layouts.website')
@section('body')



    <div class="products call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>UPI - Pay</h2>
                        <h4>{{ config('app.upi') }}</h4>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class='row'>
                            <div class="col-md-6 offset-md-3 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40%">Product</th>
                                <th width="10%">Price(each)</th>
                                <th width="10%">Discount(each)</th>
                                <th width="10%">GST</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Sub Total</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total=0 @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $id => $product)
                                    @php
                                        $prd_price = ($product['price'] - $product['discount']) * $product['quantity'];
                                        $tax = ($prd_price * $product['gst_percentage'])/100;
                                        $subtotal = $prd_price + $tax;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>&#8377;{{ $product['price'] }}</td>
                                        <td>&#8377;{{ $product['discount'] }}</td>
                                        <td>{{ $product['gst_percentage'] }}%</td>
                                        <td>{{ $product['quantity'] }}</td>
                                        <td>&#8377;{{ $subtotal }}</td>
                                        <td>
                                            <a href="{{ route('cart.remove', [$id]) }}" class="btn btn-danger btn-sm">X</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Continue Shopping</a>
                                </td>
                                <td colspan="2"></td>
                                <td colspan="3"><strong>Total &#8377;{{ $total }}(Shipping Excluded)</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <br>
                @if(session('cart'))
                <div class="inner-content">
                    <div class="col-12 row">
                        <h4>Shipping Details</h4>
                    </div>
                    <br>
                    <div class="contact-form row">
                        <form action='{{ route("payment.checkout") }}' method='POST'>
                            @csrf
                            <input type="hidden" name="order[customer_id]" value="{{ Auth::guard('customer')->user()->id }}">
                            <input type="hidden" name="order[order_details]" value="{{ json_encode(session('cart')) }}">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">First Name:</label>
                                        <input type="text" name="order[customer_first_name]" value="{{ Auth::guard('customer')->user()->name }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                         <label class="control-label">Last Name:</label>
                                         <input type="text" name="order[customer_last_name]" value="" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                      <div class="form-group">
                                           <label class="control-label">Email:</label>
                                           <input type="text" name="order[customer_email]" value="{{ Auth::guard('customer')->user()->email }}" class="form-control" required>
                                      </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                     <div class="form-group">
                                          <label class="control-label">Phone:</label>
                                          <input type="text" name="order[customer_mobile]" value="{{ Auth::guard('customer')->user()->phone }}" class="form-control" required>
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                     <div class="form-group">
                                          <label class="control-label">Address 1:</label>
                                          <input type="text" name="order[delivery_address_1]" value="" class="form-control" required>
                                     </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                     <div class="form-group">
                                          <label class="control-label">Address 2:</label>
                                          <input type="text" name="order[delivery_address_2]" value="" class="form-control">
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-sm-6 col-xs-12">
                                      <div class="form-group">
                                           <label class="control-label">City:</label>
                                           <input type="text" name="order[delivery_city]" value="" class="form-control" required>
                                      </div>
                                 </div>
                                 <div class="col-sm-6 col-xs-12">
                                      <div class="form-group">
                                           <label class="control-label">State:</label>
                                           <input type="text" name="order[delivery_state]" value="" class="form-control" required>
                                      </div>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                     <div class="form-group">
                                          <label class="control-label">Zip:</label>
                                          <input type="text" name="order[delivery_pincode]" value="" class="form-control" required>
                                     </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Payment method</label>

                                        <select name="order[payment_type]" class="form-control" required>
                                              <option value="">-- Choose --</option>
                                              <option value="upi">UPI</option>
                                              <option value="cheque">Cheque</option>
                                              <option value="COD">Cash On Delivery</option>
                                              <!--<option value="paypal">PayPal</option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <button type='submit' class="filled-button pull-right">Check Out</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection