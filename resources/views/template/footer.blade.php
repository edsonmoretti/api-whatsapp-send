<div class="copyright bg-white">
    <p>
       &copy; <span id="copy-year">{{ date('Y') }}</span>  {{ env('APP_NAME') }} v{{ env('APP_VERSION') }} - Desenvolvido por {!! env('APP_VENDOR') !!}.
    </p>
</div>
{{--<script>--}}
{{--    var d = new Date();--}}
{{--    var year = d.getFullYear();--}}
{{--    document.getElementById("copy-year").innerHTML = year;--}}
{{--</script>--}}

{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCn8TFXGg17HAUcNpkwtxxyT9Io9B_NcM" defer></script>--}}
<script src="{{ asset('assets/plugins/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-mask-input/jquery.mask.js') }}"></script>
<script src="{{ asset('assets/plugins/toaster/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/charts/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/jekyll-search.min.js') }}"></script>

<script src="{{ asset('js/sleek.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/date-range.js') }}"></script>
<script src="{{ asset('js/map.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{ asset('js/custom.js') }}"></script>

<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
@yield('extra_scritps')
