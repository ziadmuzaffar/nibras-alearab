@props(['icon' => 'box', 'class' => 'w-5 h-5'])

@php
    $rawIcon = trim($icon ?? 'box');
    $iconLower = strtolower($rawIcon);

    $presetMap = [
        'box'         => 'fa-solid fa-box-open',
        'boxes'       => 'fa-solid fa-boxes-stacked',
        'packaging'   => 'fa-solid fa-box-open',
        'card'        => 'fa-solid fa-id-card',
        'cards'       => 'fa-solid fa-id-card',
        'bag'         => 'fa-solid fa-bag-shopping',
        'bags'        => 'fa-solid fa-bag-shopping',
        'book'        => 'fa-solid fa-book-open',
        'books'       => 'fa-solid fa-book-open',
        'tag'         => 'fa-solid fa-tags',
        'tags'        => 'fa-solid fa-tags',
        'sticker'     => 'fa-solid fa-tags',
        'stickers'    => 'fa-solid fa-tags',
        'printer'     => 'fa-solid fa-print',
        'print'       => 'fa-solid fa-print',
        'gift'        => 'fa-solid fa-gift',
        'gifts'       => 'fa-solid fa-gift',
        'flag'        => 'fa-solid fa-flag',
        'banner'      => 'fa-solid fa-flag',
        'folder'      => 'fa-solid fa-folder-open',
        'folders'     => 'fa-solid fa-folder-open',
        'stamp'       => 'fa-solid fa-stamp',
        'seal'        => 'fa-solid fa-stamp',
        'shirt'       => 'fa-solid fa-shirt',
        'clothes'     => 'fa-solid fa-shirt',
        'cup'         => 'fa-solid fa-mug-hot',
        'mug'         => 'fa-solid fa-mug-hot',
        'calendar'    => 'fa-solid fa-calendar-days',
        'pen'         => 'fa-solid fa-pen-nib',
        'palette'     => 'fa-solid fa-palette',
        'envelope'    => 'fa-solid fa-envelope-open-text',
        'certificate' => 'fa-solid fa-certificate',
        'award'       => 'fa-solid fa-award',
        'ribbon'      => 'fa-solid fa-ribbon',
        'newspaper'   => 'fa-solid fa-newspaper',
        'barcode'     => 'fa-solid fa-barcode',
        'qrcode'      => 'fa-solid fa-qrcode',
        'shapes'      => 'fa-solid fa-shapes',
        'layer-group' => 'fa-solid fa-layer-group',
        'truck'       => 'fa-solid fa-truck-fast',
        'image'       => 'fa-solid fa-image',
    ];

    if (isset($presetMap[$iconLower])) {
        $faClass = $presetMap[$iconLower];
    } elseif (str_contains($iconLower, 'fa-solid') || str_contains($iconLower, 'fa-regular') || str_contains($iconLower, 'fa-brands') || str_contains($iconLower, 'fas ') || str_contains($iconLower, 'far ') || str_contains($iconLower, 'fab ')) {
        $faClass = $rawIcon;
    } elseif (str_starts_with($iconLower, 'fa-')) {
        $faClass = 'fa-solid ' . $rawIcon;
    } elseif (!empty($iconLower)) {
        $faClass = 'fa-solid fa-' . $rawIcon;
    } else {
        $faClass = 'fa-solid fa-box-open';
    }

    // Dynamic sizing based on Tailwind width/height utility classes
    $sizeStyle = '';
    if (str_contains($class, 'w-10') || str_contains($class, 'h-10')) {
        $sizeStyle = 'font-size: 1.75rem;';
    } elseif (str_contains($class, 'w-8') || str_contains($class, 'h-8')) {
        $sizeStyle = 'font-size: 1.35rem;';
    } elseif (str_contains($class, 'w-6') || str_contains($class, 'h-6')) {
        $sizeStyle = 'font-size: 1.15rem;';
    } elseif (str_contains($class, 'w-5') || str_contains($class, 'h-5')) {
        $sizeStyle = 'font-size: 1rem;';
    } elseif (str_contains($class, 'w-4') || str_contains($class, 'h-4')) {
        $sizeStyle = 'font-size: 0.875rem;';
    }
@endphp

<span class="{{ $class }} inline-flex items-center justify-center text-center shrink-0 leading-none" @if($sizeStyle) style="{{ $sizeStyle }}" @endif aria-hidden="true">
    <i class="{{ $faClass }}"></i>
</span>
