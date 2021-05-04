{{-- <div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">
        {!! trans('cookie-consent::texts.message') !!}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookie-consent::texts.agree') }}
    </button>

</div> --}}

<div class="modal fade border-0 js-cookie-consent cookie-consent" id="modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body border-0 cookie-consent__message">
                <br>
                <h6 align="center">{!! trans('cookie-consent::texts.message') !!}</h6>
            </div>
            <div class="modal-footer border-0 justify-content-between">
                {{-- <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-block btn-primary js-cookie-consent-agree cookie-consent__agree" data-dismiss="modal">
                    {{ trans('cookie-consent::texts.agree') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
