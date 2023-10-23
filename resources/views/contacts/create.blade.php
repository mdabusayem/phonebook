@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-6 col-md-offset-2" style="margin: 0 auto;">
            <div class="panel panel-default">
                <div class="panel-heading">Create Contact</div>
                <div class="panel-body">
                    <form id="createContactForm" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-12 control-label">Name</label>
                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" autofocus>
                                <span class="text-danger error-text name_err"></span>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-12 control-label">Address</label>
                            <div class="col-md-12">
                                <input id="address" type="text" class="form-control" name="address" >
                                <span class="text-danger error-text address_err"></span>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="phone_numbers" class="col-md-12 control-label">Phone Numbers</label>
                            <div class="col-md-12">
                                <div class="phone-number-fields">
                                    <div class="phone-number">
                                        <select name="phone_operators[]" class="form-control">
                                        <option value="">Select</option>
                                            <option value="GP">GP</option>
                                            <option value="Robi">Robi</option>
                                            <option value="Banglalink">Banglalink</option>
                                            <option value="Airtel">Airtel</option>
                                            <option value="Teletalk">Teletalk</option>
                                        </select>
                                        <span class="text-danger error-text phone_operators_err"></span>
                                        <input type="text" name="phone_numbers[]" class="form-control" placeholder="Phone Number (e.g., 01xxxxxxxxx)" >
                                        <span class="text-danger error-text phone_numbers_err" id=""></span>
                                    </div>
                                    
                                </div>
                                <button type="button" class="add-phone-number">Add Phone Number</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Contact
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        $('.add-phone-number').on('click', function() {
            $('.phone-number-fields').append('<div class="phone-number"><select name="phone_operators[]" class="form-control"><option value="GP">GP</option><option value="Robi">Robi</option><option value="Banglalink">Banglalink</option><option value="Airtel">Airtel</option><option value="Teletalk">Teletalk</option></select><input type="text" name="phone_numbers[]" class="form-control" placeholder="Phone Number (e.g., 01xxxxxxxxx)" pattern="01[0-9]{9}" required></div>');
        });

        $('#createContactForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route('contacts.store') }}',
                data: formData,
                success: function(data) {
                    
                    //$('#createContactForm').trigger("reset");
                    alert('Successfully created.');
                    window.location.href = "/contacts";
                },
                error: function(error) {
                    var errors = error.responseJSON;

                    printErrorMsg(error.responseJSON.errors);
                   // console.log(errors);
                }
            });
        });
    });
    function printErrorMsg (msg) {
      //  console.log(msg);
      $('.error-text').text('');
      
      $.each( msg, function( key, value ) {
       // console.log('#'+key+'_err');
       if(key=='phone_operators.0')
       {
        key='phone_operators';
       }
       if(key=='phone_numbers.0')
       {
        key='phone_numbers';
       }
        $('.'+key+'_err').text(value);
      });
        }  
</script>

@endsection
