    {{-- <script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{asset('assets/validation/js/jquery.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script> --}}

    <script src="{{ asset('theme/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/js/custom.js') }}"></script>

    {{-- <script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/validation/js/jquery_validation.js')}}"></script> --}}
    
    <script src="{{asset('assets/validation/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/validation/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/validation/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/validation/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('theme/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{asset('assets/validation/js/custom.js')}}"></script>
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
</body>
</html>
