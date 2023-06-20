<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>SMS Interface</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="https://img.icons8.com/?size=512&id=91967&format=png" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="col-md-4 offset-md-4">
                <section class="main">
                    <div class="section-header text-center">
                        <h4>Send Messages</h4>
                    </div>
                    <br>
                    <div class="section-body">
                        <form action="{{ url('send') }}" method="POST" id="sendMessage">
                            @csrf
                            <input type="hidden" name="page" id="current_page" value="1">
                            <div class="form-group">
                                <label for="sender_id">Sender ID</label>
                                <input type="text" name="sender_id" id="sender_id" class="form-control" placeholder="Your sender ID" value="{{ old('sender_id') }}" required="required">
                                @error('sender_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="recipients">Recipients</label>
                                <textarea type="textarea" name="recipients" id="recipients" class="form-control" required="required">{{ old('recipients') }}</textarea>
                                @error('recipients')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="message">Write Message</label>
                                <textarea type="textarea" name="message" id="message" class="form-control" required="required">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                <div class="float-right">
                                    <span id="pageMessage"></span>
                                </div>
                                <br>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-block float-right btn-success">Send</button>
                            <br><br>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal fade" id="billSummaryModal" tabindex="-1" role="dialog" aria-labelledby="billSummaryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content c-black">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="billSummaryModalLabel">Bill Summary</h5>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Total phone numbers</td>
                                    <td id="total_numbers"></td>
                                </tr>
                                <tr>
                                    <td>Message per page</td>
                                    <td id="total_pages"></td>
                                </tr>
                                <tr>
                                    <td>Cost</td>
                                    <td id="total_cost"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Proceed to Payment</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/limit-counter.js') }}"></script>
        <script src="{{ asset('assets/js/send.js') }}"></script>
    </body>
</html>
