@component('layouts.master')

    @slot('title')
        Edit payment method - {{ config('app.name') }}
    @endslot

    <div class="row content">

        <div class="col-md-12">
            <!-- Nav tabs -->
            @include('users.tabs')

            <ol class="breadcrumb">
                <li><a href="{{ route('payments') }}" role="tab">Payment Methods</a></li>
                <li class="active">Edit payment method</li>
            </ol>

            <h1>Edit Credit Card</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('payments.update', $paymentSource['id']) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
                            <label class="control-label">Primary Card?</label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="default" value="1"{{ old('default', $paymentSource['default']) ? ' cheecked' : '' }} />

                                Yes
                            </label>

                            <p class="help-block">
                                Check "Yes" to make this card as your primary card for payments when you make purchases with us.
                                Doing so will automatically make other cards, if any, non-primary.
                            </p>

                            @include('snippets.errors_first', ['param' => 'default'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success" title="Update this address"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>

            </form>

            <div class="row">
                <div class="col-md-12">
                    <br />
                    <label>Remove this card?</label>

                    <form method="POST" action="{{ route('payments.destroy', $paymentSource['id']) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this card?');">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endcomponent