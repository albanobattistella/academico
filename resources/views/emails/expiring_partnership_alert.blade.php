@lang('The partnership with :partner expires on :date.', ['partner' => $partner->name, 'date' => \Carbon\Carbon::parse($partner->expired_on)->locale(app()->getLocale())->isoFormat('Do MMM YYYY')])

@if ($partner->auto_renewal)
@lang('This partnership is automatically renewed.')
@else
@lang('This partnership is not automatically renewed.')
@endif
