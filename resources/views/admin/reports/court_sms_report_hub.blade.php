@extends('dashboard.layouts.admin')
@section('title', app()->getLocale() === 'bn' ? 'বিস্তারিত রিপোর্ট' : 'Detailed Reports')

@php
    $isBn = app()->getLocale() === 'bn';
    $ui = $isBn
        ? [
            'title' => 'বিস্তারিত রিপোর্ট',
            'subtitle' => 'প্রয়োজনমতো রিপোর্ট খুলুন। পাতা হালকা থাকবে, কাজও সহজ হবে।',
            'filter_title' => 'ফিল্টার',
            'filter_copy' => 'আপনার লগইনভিত্তিক সীমা ঠিক থাকবে।',
            'scope_label' => 'বর্তমান পরিধি',
            'scope_copy' => 'আপনার অ্যাক্সেস অনুযায়ী রিপোর্ট দেখানো হচ্ছে।',
            'apply' => 'দেখুন',
            'reset' => 'রিসেট',
            'open' => 'খুলুন',
            'division' => 'সব বিভাগ',
            'district' => 'সব জেলা',
            'court' => 'সব কোর্ট',
            'from' => 'শুরুর তারিখ',
            'to' => 'শেষ তারিখ',
            'reports_suffix' => 'টি রিপোর্ট',
        ]
        : [
            'title' => 'Detailed Reports',
            'subtitle' => 'Open the report you need with a lighter, filter-first layout.',
            'filter_title' => 'Filters',
            'filter_copy' => 'Your login-based restriction stays enforced automatically.',
            'scope_label' => 'Current Scope',
            'scope_copy' => 'Reports are shown according to your access level.',
            'apply' => 'Apply',
            'reset' => 'Reset',
            'open' => 'Open',
            'division' => 'All Divisions',
            'district' => 'All Districts',
            'court' => 'All Courts',
            'from' => 'From Date',
            'to' => 'To Date',
            'reports_suffix' => 'reports',
        ];

    $locationTree = $divisions->map(fn ($division) => [
        'id' => $division->id,
        'name_en' => $division->name_en,
        'name_bn' => $division->name_bn,
        'districts' => $division->districts->map(fn ($district) => [
            'id' => $district->id,
            'name_en' => $district->name_en,
            'name_bn' => $district->name_bn,
            'courts' => $district->courts->map(fn ($court) => [
                'id' => $court->id,
                'name_en' => $court->name_en,
                'name_bn' => $court->name_bn,
            ])->values(),
        ])->values(),
    ])->values();
@endphp

@section('content')
<div class="container-fluid py-3 report-hub">
    <div class="hub-top">
        <div class="hero-copy">
            <span class="hub-kicker">{{ $ui['title'] }}</span>
            <h1>{{ $ui['title'] }}</h1>
        </div>
        <div class="scope-box">
            <span>{{ $ui['scope_label'] }}</span>
            <strong>{{ $dashboardMode['label'] ?? '' }}</strong>
        </div>
    </div>

    <div class="card hub-filter border-0 shadow-sm mt-3">
        <div class="card-body">
            <div class="filter-top">
                <div>
                    <h3>{{ $ui['filter_title'] }}</h3>
                </div>
                <div class="filter-actions">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="hubReset">{{ $ui['reset'] }}</button>
                    <button type="button" class="btn btn-primary btn-sm" id="hubApply">{{ $ui['apply'] }}</button>
                </div>
            </div>

            <div class="filter-grid">
                <div class="filter-field">
                    <label class="form-label">{{ __('dashboard.division') }}</label>
                    <select id="hubDivision" class="form-select form-select-sm"></select>
                </div>
                <div class="filter-field">
                    <label class="form-label">{{ __('dashboard.district') }}</label>
                    <select id="hubDistrict" class="form-select form-select-sm"></select>
                </div>
                <div class="filter-field">
                    <label class="form-label">{{ __('dashboard.court') }}</label>
                    <select id="hubCourt" class="form-select form-select-sm"></select>
                </div>
                <div class="filter-field">
                    <label class="form-label">{{ $ui['from'] }}</label>
                    <input type="date" id="hubFromDate" class="form-control form-control-sm" value="{{ $filters['from_date'] }}">
                </div>
                <div class="filter-field">
                    <label class="form-label">{{ $ui['to'] }}</label>
                    <input type="date" id="hubToDate" class="form-control form-control-sm" value="{{ $filters['to_date'] }}">
                </div>
            </div>
        </div>
    </div>

    <div class="hub-summary mt-3">
        @foreach ($groups as $group)
            <div class="summary-chip">
                <strong>{{ $group['title'] }}</strong>
                <span>{{ count($group['reports']) }} {{ $ui['reports_suffix'] }}</span>
            </div>
        @endforeach
    </div>

    @foreach ($groups as $groupIndex => $group)
        <section class="report-section section-{{ ($groupIndex % 4) + 1 }} mt-3">
            <div class="section-head">
                <div>
                    <h3>{{ $group['title'] }}</h3>
                </div>
            </div>
            <div class="section-body">
                @foreach ($group['reports'] as $reportItem)
                    @php $meta = $reports[$reportItem['key']] ?? null; @endphp
                    @if ($meta)
                        <article class="report-item">
                            <div class="report-item__icon tone-{{ $reportItem['tone'] }}">
                                <i class="bi {{ $reportItem['icon'] }}"></i>
                            </div>
                            <div class="report-item__body">
                                <div class="report-item__title">{{ $meta['title'] }}</div>
                                <div class="report-item__desc">{{ $meta['description'] }}</div>
                            </div>
                            <div class="report-item__action">
                                <button type="button" class="btn btn-dark btn-sm report-link" data-report-type="{{ $reportItem['key'] }}">
                                    {{ $ui['open'] }}
                                </button>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </section>
    @endforeach
</div>
@endsection

@push('styles')
<style>
.report-hub{--ink:#17324d;--muted:#647789;--line:rgba(23,50,77,.12)}
.hub-top{display:grid;grid-template-columns:minmax(0,1fr) 220px;gap:.9rem;align-items:start;background:linear-gradient(135deg,#eef7ff 0%,#fff7ea 55%,#f7f2ff 100%);border:1px solid var(--line);border-radius:18px;padding:1rem 1.05rem;box-shadow:0 10px 26px rgba(18,43,71,.08)}
.hero-copy{min-width:0}
.hub-kicker{display:inline-flex;padding:.28rem .65rem;border-radius:999px;background:rgba(10,132,255,.12);color:#0e5cb4;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em}
.hub-top h1{margin:.42rem 0 .28rem;font-size:1.45rem;font-weight:800;color:var(--ink)}
.hub-top p{margin:0;color:var(--muted);font-size:.93rem;line-height:1.5}
.scope-box{background:rgba(255,255,255,.85);border:1px solid rgba(23,50,77,.08);border-radius:14px;padding:.75rem .8rem}
.scope-box span,.scope-box small{display:block;color:var(--muted)}
.scope-box span{font-size:.74rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em}
.scope-box strong{display:block;color:var(--ink);font-size:.98rem;margin:.16rem 0}
.hub-filter{border-radius:16px}
.filter-top{display:flex;justify-content:space-between;gap:.8rem;align-items:flex-start;margin-bottom:.85rem}
.filter-top h3{font-size:1rem;font-weight:800;color:var(--ink);margin:0 0 .15rem}
.filter-top p{margin:0;color:var(--muted);font-size:.88rem}
.filter-actions{display:flex;gap:.45rem;flex-wrap:wrap}
.filter-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:.7rem}
.filter-field .form-label{margin-bottom:.28rem;font-size:.8rem;color:var(--muted);font-weight:700}
.hub-summary{display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:.55rem}
.summary-chip{display:flex;justify-content:space-between;align-items:center;gap:.5rem;padding:.7rem .8rem;border-radius:12px;background:#fff;border:1px solid var(--line);box-shadow:0 4px 14px rgba(18,43,71,.05)}
.summary-chip strong{color:var(--ink);font-size:.88rem}
.summary-chip span{color:var(--muted);font-size:.8rem;font-weight:700}
.report-section{border:1px solid var(--line);border-radius:16px;overflow:hidden;background:#fff;box-shadow:0 8px 24px rgba(18,43,71,.06)}
.section-head{padding:.85rem 1rem;border-bottom:1px solid rgba(23,50,77,.08)}
.section-head h3{margin:0 0 .18rem;font-size:1rem;font-weight:800;color:var(--ink)}
.section-head p{margin:0;font-size:.87rem;color:var(--muted);line-height:1.45}
.section-1 .section-head{background:linear-gradient(90deg,#edf7ff 0%,#ffffff 100%)}
.section-2 .section-head{background:linear-gradient(90deg,#f2fcf5 0%,#ffffff 100%)}
.section-3 .section-head{background:linear-gradient(90deg,#fff8ed 0%,#ffffff 100%)}
.section-4 .section-head{background:linear-gradient(90deg,#f7f2ff 0%,#ffffff 100%)}
.section-body{padding:.15rem .7rem}
.report-item{display:grid;grid-template-columns:44px minmax(0,1fr) auto;gap:.7rem;align-items:center;padding:.8rem .1rem;border-bottom:1px solid rgba(23,50,77,.08)}
.report-item:last-child{border-bottom:none}
.report-item__icon{width:38px;height:38px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:.95rem;border:1px solid rgba(23,50,77,.08)}
.report-item__title{font-size:.94rem;font-weight:800;color:var(--ink);margin-bottom:.12rem}
.report-item__desc{font-size:.85rem;line-height:1.42;color:var(--muted)}
.report-item__action .btn{border-radius:10px;padding:.45rem .8rem;white-space:nowrap}
.tone-primary{background:linear-gradient(180deg,#f1f8ff 0%,#dfefff 100%);color:#145ea8}
.tone-success{background:linear-gradient(180deg,#eefaf1 0%,#dbf3e3 100%);color:#147a42}
.tone-info{background:linear-gradient(180deg,#eef9ff 0%,#dff2ff 100%);color:#0f6b8f}
.tone-warning{background:linear-gradient(180deg,#fff8ec 0%,#ffefd1 100%);color:#a76400}
.tone-secondary{background:linear-gradient(180deg,#f4f6fa 0%,#e8edf5 100%);color:#4b5d73}
.tone-dark{background:linear-gradient(180deg,#f4f1ff 0%,#e9e1ff 100%);color:#5d46b3}
@media (max-width:1100px){.filter-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media (max-width:900px){.hub-top{grid-template-columns:1fr}.filter-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.report-item{grid-template-columns:44px minmax(0,1fr)}.report-item__action{grid-column:1 / -1;padding-left:52px}}
@media (max-width:640px){.report-hub{padding-left:.35rem;padding-right:.35rem}.hub-top{padding:.9rem}.hub-top h1{font-size:1.2rem}.filter-top{flex-direction:column}.filter-actions{width:100%}.filter-actions .btn{flex:1}.filter-grid{grid-template-columns:1fr}.hub-summary{grid-template-columns:1fr 1fr}.report-item{grid-template-columns:1fr;padding:.75rem 0}.report-item__icon{display:none}.report-item__action{grid-column:auto;padding-left:0}.summary-chip{padding:.6rem .7rem}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tree = @json($locationTree);
    const locale = '{{ app()->getLocale() }}';
    const fixedDivision = '{{ $user->division_id ?? '' }}';
    const fixedDistrict = '{{ $user->district_id ?? '' }}';
    const fixedCourt = '{{ $user->court_id ?? '' }}';
    const initial = @json($filters);
    const division = document.getElementById('hubDivision');
    const district = document.getElementById('hubDistrict');
    const court = document.getElementById('hubCourt');
    const fromDate = document.getElementById('hubFromDate');
    const toDate = document.getElementById('hubToDate');
    const openButtons = document.querySelectorAll('.report-link');

    function nameOf(item) { return locale === 'bn' ? (item.name_bn || item.name_en) : (item.name_en || item.name_bn); }
    function byId(items, id) { return items.find(item => String(item.id) === String(id)) || null; }
    function setOptions(select, items, placeholder, selected = '') {
        select.innerHTML = '';
        const first = document.createElement('option');
        first.value = '';
        first.textContent = placeholder;
        select.appendChild(first);
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = nameOf(item);
            if (String(item.id) === String(selected)) option.selected = true;
            select.appendChild(option);
        });
    }
    function divisions() { return tree; }
    function selectedDivision() { return byId(divisions(), division.value); }
    function districts() { return selectedDivision() ? selectedDivision().districts : []; }
    function selectedDistrict() { return byId(districts(), district.value); }
    function courts() { return selectedDistrict() ? selectedDistrict().courts : []; }
    function sync(filters = {}) {
        setOptions(division, divisions(), @json($ui['division']), filters.division_id || fixedDivision || '');
        setOptions(district, districts(), @json($ui['district']), filters.district_id || fixedDistrict || '');
        setOptions(court, courts(), @json($ui['court']), filters.court_id || fixedCourt || '');
        if (fixedDivision) division.value = fixedDivision;
        if (fixedDistrict) district.value = fixedDistrict;
        if (fixedCourt) court.value = fixedCourt;
        division.disabled = Boolean(fixedDivision);
        district.disabled = districts().length === 0 || Boolean(fixedDistrict);
        court.disabled = courts().length === 0 || Boolean(fixedCourt);
    }
    function params() {
        const p = new URLSearchParams();
        if (division.value) p.set('division_id', division.value);
        if (district.value) p.set('district_id', district.value);
        if (court.value) p.set('court_id', court.value);
        if (fromDate.value) p.set('from_date', fromDate.value);
        if (toDate.value) p.set('to_date', toDate.value);
        return p.toString();
    }
    function applyFilters() {
        const query = params();
        const url = '{{ route('admin.reports.detailed') }}';
        window.location.href = query ? `${url}?${query}` : url;
    }

    division.addEventListener('change', () => {
        setOptions(district, districts(), @json($ui['district']), '');
        setOptions(court, [], @json($ui['court']), '');
        district.disabled = districts().length === 0 || Boolean(fixedDistrict);
        court.disabled = true;
    });
    district.addEventListener('change', () => {
        setOptions(court, courts(), @json($ui['court']), '');
        court.disabled = courts().length === 0 || Boolean(fixedCourt);
    });
    document.getElementById('hubApply').addEventListener('click', applyFilters);
    document.getElementById('hubReset').addEventListener('click', () => {
        fromDate.value = '';
        toDate.value = '';
        sync({ division_id: fixedDivision || '', district_id: fixedDistrict || '', court_id: fixedCourt || '' });
        applyFilters();
    });
    openButtons.forEach(button => button.addEventListener('click', () => {
        const base = '{{ route('admin.reports.court_sms_dashboard.report', ['type' => '__TYPE__']) }}'.replace('__TYPE__', button.dataset.reportType);
        const query = params();
        window.location.href = query ? `${base}?${query}` : base;
    }));

    sync(initial);
});
</script>
@endpush
