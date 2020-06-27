<div class="form-group">
  <label for="name"> Name </label>
  <!-- Since we passed an empty Customer model in the create method -->
  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') ?? $customer->name }}">
  @if( $errors->any() )
  <!--
  Another way to add validation messages to blade. Kept it here just for reference. This uses the blade directive called
  @/error to check if an error for the "name" variable exists. If not, the next indented div alert will not work
  -->
    @error('name')
      <div class="alert alert-danger mt-2"> {{ $errors->first('name') }} </div>
    @enderror
  @endif
</div>
<div class="form-group">
  <label for="email"> Email </label>
  <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') ?? $customer->email  }}">
</div>
<div class="form-group">
    <label for="active">Status</label>
    <select name="active" id="active" class="form-control">
        <option value="" disabled>Select customer status</option>

        @foreach($customer->activeOptions() as $activeOptionKey => $activeOptionValue)
            <option value="{{ $activeOptionKey }}" {{ $customer->active == $activeOptionValue ? 'selected' : '' }}>{{ $activeOptionValue }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
  <label for="company_id"> Company </label>
  <select class="form-control" name="company_id" id="company_id">
    <option value="" disabled selected> Select Company </option>
    @foreach ($companies as $company)
      <option value="{{ $company->id }}" {{ $company->id == $customer->company_id ? 'selected' : '' }}> {{ $company->name }} </option>
    @endforeach
  </select>
</div>
