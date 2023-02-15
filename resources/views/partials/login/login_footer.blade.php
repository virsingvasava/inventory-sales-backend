</div>
<script src="{{asset('assets/validation/js/toastr.min.js')}}"></script>
<script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif
  
    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif
  
    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif
  
    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('theme/js/custom.js') }}"></script>
</body>
</html>
