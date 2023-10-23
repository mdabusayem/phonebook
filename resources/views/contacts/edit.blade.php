@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Contact</div>
                <div class="panel-body">
                    <form id="editContactForm" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $contact->name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $contact->address }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_numbers" class="col-md-4 control-label">Phone Numbers</label>
                            <div class="col-md-6">
                                <div class="phone-number-fields">
                                    @foreach ($contact->phoneNumbers as $phoneNumber)
                                    <div class="phone-number">
                                        <select name="phone_operators[]" class="form-control">
                                            <option value="GP" {{ $phoneNumber->operator == 'GP' ? 'selected' : '' }}>GP</option>
                                            <option value="Robi" {{ $phoneNumber->operator == 'Robi' ? 'selected' : '' }}>Robi</option>
                                            <option value="Banglalink" {{ $phoneNumber->operator == 'Banglalink' ? 'selected' : '' }}>Banglalink</option>
                                            <option value="Airtel" {{ $phoneNumber->operator == 'Airtel' ? 'selected' : '' }}>Airtel</option>
                                            <option value="Teletalk" {{ $phoneNumber->operator == 'Teletalk' ? 'selected' : '' }}>Teletalk</option>
                                        </select>
                                        <input type="text" name="phone_numbers[]" class="form-control" value="{{ $phoneNumber->number }}" placeholder="Phone Number (e.g., 01xxxxxxxxx)" pattern="01[0-9]{9}" required>
                                    </div>
                                    @endforeach
                                    
                                </div>
                                <button type="button" class="add-phone-number">Add Phone Number</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Contact
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

        $('#editContactForm').submit(function(e) {
            e.preventDefault();

            // Gather form data
            var formData = $(this).serialize();
            var id = {{$contact->id}};
            $.ajax({
                method: 'POST',
                url: '{{ route('contacts.update', $contact->id) }}',
                data:{
                'id': id,
                    '_token': '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                data: formData,
                success: function(data) {
                    alert('Successfully updated.');
                    window.location.href = "/contacts";
                },
                error: function(error) {
                  
                    var errors = error.responseJSON;
                    console.log(errors);
                }
            });
        });

        
    });
</script>
@endsection
