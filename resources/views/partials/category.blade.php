<li class="list-group-item" style="border: 0; padding: 10px 0;">
    <a href="{{ route('shop.category', [$category['uri'], $category['id']]) }}" title="View this category" class="list-group-item">
        <i class="fa fa-chevron-right"></i> {{ $category['name'] }}
    </a>
</li>
@if (!empty($category['children']))
    <li class="list-group-item">
        <ul class="list-group" style="margin-bottom: 0;">
            @foreach ($category['children'] as $category)
                @include('partials.category', $category)
            @endforeach
        </ul>
    </li>
@endif