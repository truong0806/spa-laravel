@php
    $sitesetup = App\Models\Setting::where('type', 'site-setup')->where('key', 'site-setup')->first();
    $datetime = $sitesetup ? json_decode($sitesetup->value) : null;
@endphp
{{ Form::hidden('id', $bookingdata->id) }}

<div class="card-body p-0">
    <div class="border-bottom pb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <h3 class="c1 mb-2">{{__('messages.book_id')}} {{ '#' . $bookingdata->id ?? '-'}}</h3>
            <p class="opacity-75 fz-12">
                {{__('messages.book_placed')}}
                {{ date("$datetime->date_format / $datetime->time_format", strtotime($bookingdata->created_at)) ?? '-'}}
            </p>
        </div>
        <div class="d-flex flex-wrap flex-xxl-nowrap gap-3" data-select2-id="select2-data-8-5c7s">
            <div class="w3-third">
                @if($bookingdata->handymanAdded->count() == 0)
                    @hasanyrole('admin|demo_admin|provider')
                    <a href="{{ route('booking.assign_form', ['id' => $bookingdata->id]) }}"
                        class="float-right btn btn-sm btn-primary loadRemoteModel"><i class="lab la-telegram-plane"></i>
                        {{ __('messages.assign') }}</a>
                    @endhasanyrole
                @endif
            </div>
            @if($bookingdata->payment_id !== null)
                <a href="{{route('invoice_pdf', $bookingdata->id)}}" class="btn btn-primary" target="_blank">
                    <i class="ri-file-text-line"></i>

                    {{__('messages.invoice')}}
                </a>
            @endif
        </div>
    </div>
    <div class="pay-box">
        <div class="pay-method-details">
            <h4 class="mb-2" style="font-size: var(--h5_fz);">{{__('messages.payment_method')}}</h4>
            @if (!empty(optional($bookingdata->payment)->payment_type))
                <h5 class="c1 mb-2">{{ optional($bookingdata->payment)->payment_type }}</h5>
            @else
                <h5 class="c1 mb-2">-</h5>
            @endif
            <p><span>{{__('messages.amount')}} :
                </span><strong>{{!empty($bookingdata->total_amount) ? getPriceFormat($bookingdata->total_amount) : 0}}</strong>
            </p>
        </div>
        <div class="pay-booking-details">
            <div class="row mb-2">
                <div class="col-sm-6"><span>{{__('messages.booking_status')}} :</span></div>
                <div class="col-sm-6 align-text">
                    <span class="c1"
                        id="booking_status__span">{{  App\Models\BookingStatus::bookingStatus($bookingdata->status)}}</span>
                </div>
                @if($bookingdata->status === "cancelled")
                    <div class="col-sm-6"><span>{{__('messages.reason')}} :</span></div>
                    <div class="col-sm-6 align-text">
                        <span class="c1" id="booking_status__span">{{ $bookingdata->reason }}</span>
                    </div>
                @endif
            </div>
            <div class="row mb-2">
                <div class="col-sm-6"> <span>{{__('messages.payment_status')}} : </span></div>
                <div class="col-sm-6 align-text">
                    <span id="payment_status__span"
                        class="{{ optional($bookingdata->payment)->payment_status == 'paid' ? 'text-success' : 'text-danger' }}">
                        {{ ucwords(str_replace('_', ' ', optional($bookingdata->payment)->payment_status ?: 'pending'))}}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h5>
                        {{__('messages.booking_date')}} :
                    </h5>
                </div>
                <div class="col-sm-6 align-text">
                    <span
                        id="service_schedule__span">{{ date("$datetime->date_format / $datetime->time_format", strtotime($bookingdata->date)) ?? '-'}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 d-flex gap-3 flex-wrap customer-info-detail mb-2">
        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('messages.customer_information')}}</h4>
            <h5 class="c1 mb-3">{{optional($bookingdata->customer)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                    <a href="tel:{{optional($bookingdata->customer)->contact_number}}" class="customer-info-value">
                        <p class="mb-0">{{ optional($bookingdata->customer)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons  customer-info-text">{{__('messages.address')}}</span>
                    <p class="customer-info-text">{{ optional($bookingdata->customer)->address ?? '-' }}</p>
                </li>
            </ul>
        </div>

        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('messages.provider_information')}}</h4>
            <h5 class="c1 mb-3">{{optional($bookingdata->provider)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                    <a href="tel:{{optional($bookingdata->provider)->contact_number}}" class="customer-info-value">
                        <p class="mb-0">{{ optional($bookingdata->provider)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.address')}}</span>
                    <p class="customer-info-text">{{ optional($bookingdata->provider)->address ?? '-' }}</p>
                </li>
            </ul>
        </div>

        @if(count($bookingdata->handymanAdded) > 0)
            <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                @foreach($bookingdata->handymanAdded as $booking)
                    <h4 class="mb-2">{{__('messages.handyman_information')}}</h4>
                    <h5 class="c1 mb-3">{{optional($booking->handyman)->display_name ?? '-'}}</h5>
                    <ul class="list-info">
                        <li>
                            <span class="material-icons  customer-info-text">{{__('messages.phone_information')}}</span>
                            <a href="" class=" customer-info-value">
                                <p class="mb-0">{{optional($booking->handyman)->contact_number ?? '-'}}</p>
                            </a>
                        </li>
                        <li>
                            <span class="material-icons  customer-info-text">{{__('messages.address')}}</span>
                            <p class=" customer-info-value">{{optional($booking->handyman)->address ?? '-'}}</p>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endif
    </div>
    @if($bookingdata->bookingExtraCharge->count() > 0)
        <h3 class="mb-3 mt-3">{{__('messages.extra_charge')}}</h3>
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-lg-3">{{__('messages.title')}}</th>
                        <th>{{__('messages.price')}}</th>
                        <th>{{__('messages.quantity')}}</th>
                        <th class="text-end">{{__('messages.total_amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingdata->bookingExtraCharge as $chrage)
                        <tr>
                            <td class="text-wrap ps-lg-3">
                                <div class="d-flex flex-column">
                                    <a href="" class="booking-service-link fw-bold">{{$chrage->title}}</a>
                                </div>
                            </td>
                            <td>{{getPriceFormat($chrage->price)}}</td>
                            <td>{{$chrage->qty}}</td>
                            <td class="text-end">{{getPriceFormat($chrage->price * $chrage->qty)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @php
        $addonTotalPrice = 0;
    @endphp

    @if($bookingdata->bookingAddonService->count() > 0)
        <h3 class="mb-3 mt-3">{{__('messages.service_addon')}}</h3>
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-lg-3">{{__('messages.title')}}</th>
                        <th>{{__('messages.price')}}</th>
                        <th class="text-end">{{__('messages.total_amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingdata->bookingAddonService as $addonservice)
                                @php
                                    $addonTotalPrice += $addonservice->price;
                                @endphp
                                <tr>
                                    <td class="text-wrap ps-lg-3">
                                        <div class="d-flex flex-column">
                                            <a href="" class="booking-service-link fw-bold">{{$addonservice->name}}</a>
                                        </div>
                                    </td>
                                    <td>{{getPriceFormat($addonservice->price)}}</td>
                                    <td class="text-end">{{getPriceFormat($addonservice->price)}}</td>
                                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h3 class="mb-3 mt-3">{{__('messages.booking_summery')}}</h3>
    <div class="table-responsive border-bottom">
        <table class="table text-nowrap align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-lg-3">{{__('messages.service')}}</th>
                    <th>{{__('messages.price')}}</th>
                    <th>{{__('messages.quantity')}}</th>
                    <th class="text-end">{{__('messages.sub_total')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-wrap ps-lg-3">
                        <div class="d-flex flex-column">
                            <a href=""
                                class="booking-service-link fw-bold">{{optional($bookingdata->service)->name ?? '-'}}</a>
                        </div>
                    </td>
                    <td>{{ isset($bookingdata->amount) ? getPriceFormat($bookingdata->amount) : 0 }}</td>
                    <td>{{!empty($bookingdata->quantity) ? $bookingdata->quantity : 0}}</td>
                    <td class="text-end">{{getPriceFormat($bookingdata->final_total_service_price)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-end mt-3">
        <div class="col-sm-10 col-md-6 col-xl-5">
            <div class="table-responsive bk-summary-table">
                <table class="table-sm title-color align-right w-100">
                    <tbody>
                        <tr>
                            <td>{{ __('messages.price') }}</td>
                            <td class="bk-value">
                                {{ getPriceFormat($bookingdata->amount) }} * {{ $bookingdata->quantity }} =
                                {{ getPriceFormat($bookingdata->amount * $bookingdata->quantity) }}
                            </td>
                        </tr>

                        @if($bookingdata->bookingPackage == null && $bookingdata->discount > 0)
                            <tr>
                                <td>{{ __('messages.discount') }} ({{ $bookingdata->discount }}% off)</td>
                                <td class="bk-value text-success">-{{ getPriceFormat($bookingdata->final_discount_amount) }}
                                </td>
                            </tr>
                        @endif

                        @if($bookingdata->couponAdded != null)
                            <tr>
                                <td>{{ __('messages.coupon') }} ({{ $bookingdata->couponAdded->code }})</td>
                                <td class="bk-value text-success">
                                    -{{ getPriceFormat($bookingdata->final_coupon_discount_amount) }}</td>
                            </tr>
                        @endif

                        @php
                            // Calculate subtotal
                            $subTotal = $bookingdata->amount * $bookingdata->quantity;

                            // Apply discount
                            if ($bookingdata->discount > 0) {
                                $subTotal -= $bookingdata->final_discount_amount;
                            }

                            // Apply coupon discount
                            if ($bookingdata->couponAdded != null) {
                                $subTotal -= $bookingdata->final_coupon_discount_amount;
                            }

                            // Calculate tax
                            $taxAmount = 0;
                            if ($bookingdata->tax != "") {
                                $taxData = json_decode($bookingdata->tax);
                                $tax_per = 0;
                                $tax_fix = 0;

                                foreach ($taxData as $value) {
                                    if ($value->type === 'percent') {
                                        $tax_per = $subTotal * $value->value / 100;
                                    } else {
                                        $tax_fix = $value->value;
                                    }
                                }

                                $taxAmount = $tax_per + $tax_fix;
                            }

                            // Calculate extra charges and add-ons
                            $extraCharges = $bookingdata->bookingExtraCharge->count() > 0 ? $bookingdata->getExtraChargeValue() : 0;
                            $addonTotalPrice = $bookingdata->bookingAddonService->count() > 0 ? $bookingdata->bookingAddonService->sum('price') : 0;

                            // Calculate totals
                            $subTotalWithTax = $subTotal + $taxAmount + $extraCharges + $addonTotalPrice;
                            $grandTotal = $subTotalWithTax;
                        @endphp

                        <tr class="grand-sub-total">
                            <td>{{ __('messages.subtotal_vat') }}</td>
                            <td class="bk-value">{{ getPriceFormat($subTotal) }}</td>
                        </tr>

                        @if($extraCharges > 0)
                            <tr>
                                <td>{{ __('messages.extra_charge') }}</td>
                                <td class="text-right text-success">+{{ getPriceFormat($extraCharges) }}</td>
                            </tr>
                        @endif

                        @if($addonTotalPrice > 0)
                            <tr>
                                <td>{{ __('messages.add_ons') }}</td>
                                <td class="text-right text-success">+{{ getPriceFormat($addonTotalPrice) }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td>{{ __('messages.tax') }} ({{ $bookingdata->tax_rate }}%)</td>
                            <td class="text-right text-danger">{{ getPriceFormat($taxAmount) }}</td>
                        </tr>

                        <tr class="grand-total">
                            <td><strong>{{ __('messages.grand_total') }}</strong></td>
                            <td class="bk-value">
                                <h3>{{ getPriceFormat($grandTotal) }}</h3>
                            </td>
                        </tr>

                        @if($bookingdata->service->is_enable_advance_payment == 1)
                            <tr>
                                <td>{{ __('messages.advance_payment_amount') }}
                                    ({{ $bookingdata->service->advance_payment_amount }}%)</td>
                                <td class="text-right">{{ getPriceFormat($bookingdata->advance_paid_amount) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.remaining_amount') }}
                                    @if(optional($bookingdata->payment)->payment_status == 'paid')


                                        <span class="badge badge-success">{{ __('messages.paid') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('messages.pending') }}</span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    {{ getPriceFormat($bookingdata->remaining_amount) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentsModal">
        View Payments List
    </button>

</div>
<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog" aria-labelledby="paymentsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentsModalLabel">Payments List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="row">
                        @foreach ($paymentsList as $payment)
                            <div class="col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4 class="card-title" style="color: green;">
                                            {{ getPriceFormat($payment->total_amount) }} ({{ $payment->payment_type }})
                                        </h4>
                                        <p class="card-text">
                                            <strong>Status:</strong> {{ 

                                                                ucwords(str_replace('_', ' ', $payment->payment_status))
                                                                 }}<br>
                                            <strong>Transaction ID:</strong> {{ $payment->txn_id }}<br>
                                            <strong>Created At:</strong> {{ $payment->created_at }}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('change', '.bookingstatus', function () {

        var status = $(this).val();

        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('bookingStatus.update') }}",
            data: {
                'status': status,
                'bookingId': id
            },
            success: function (data) { }
        });
    })

    $(document).on('change', '.paymentStatus', function () {

        var status = $(this).val();

        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('bookingStatus.update') }}",
            data: {
                'status': status,
                'bookingId': id
            },
            success: function (data) { }
        });
    })
</script>