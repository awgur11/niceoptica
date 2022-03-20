<div class="form-group">
    <label for="first_name">*@lang('Your name'):</label>
    <input type="text" class="form-control required" required=""  id="first_name" name="first_name" maxlength="50" required="" form="order-store-form" value="{{ $client->first_name ?? null }}">
</div>

<div class="form-group">
    <label for="middle_name">@lang('Your middle name'):</label>
    <input type="text" class="form-control" id="middle_name" name="middle_name" maxlength="50" form="order-store-form" value="{{ $client->middle_name ?? null }}">
</div>

<div class="form-group">
    <label for="first_name">@lang('Your last name'):</label>
    <input type="text" class="form-control"  id="last_name" name="last_name" maxlength="50" form="order-store-form" value="{{ $client->last_name ?? null }}">
</div>

<div class="form-group">
    <label for="email">@lang('Your email'):</label>
    <input type="email" class="form-control"  id="email" name="email" maxlength="150" form="order-store-form" value="{{ $client->email ?? null }}">
</div>

<div class="form-group">
    <label for="phone">*@lang('Your phone number'):</label>
    <input type="text" class="form-control required"  id="phone" name="phone" maxlength="50" required="" form="order-store-form" value="{{ $client->phone ?? null }}">
</div>

<div class="form-group">
    <label for="comment">@lang('Your comment'):</label>
    <textarea class="form-control"  id="comment" name="comment" maxlength="500" form="order-store-form" rows="5"></textarea>
</div>

