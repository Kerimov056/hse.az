<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
 @csrf
 <label>Site name <input name="site.name" value="{{ $settings['site.name'] ?? '' }}"></label>
 <label>Phone     <input name="site.phone" value="{{ $settings['site.phone'] ?? '' }}"></label>
 <label>Email     <input name="site.email" value="{{ $settings['site.email'] ?? '' }}"></label>
 <label>Address   <input name="site.address" value="{{ $settings['site.address'] ?? '' }}"></label>

 <label>Facebook  <input name="social[facebook]" value="{{ $settings['social']['facebook'] ?? '' }}"></label>
 <label>Instagram <input name="social[instagram]" value="{{ $settings['social']['instagram'] ?? '' }}"></label>

 <label>Logo      <input type="file" name="logo"></label>
 <label>Favicon   <input type="file" name="favicon"></label>

 <button>Save</button>
</form>
