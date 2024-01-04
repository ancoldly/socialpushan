<div class="grid items-center bg-white rounded-[10px] p-[20px]">
    <div class="flex items-center justify-between">
        <h1 class="font-semibold text-[20px]">Images</h1>
    </div>

    <div class="grid grid-cols-5 gap-[10px] py-[50px]">
        @if ($images->count() > 0)
            @foreach ($images as $image)
                <img src="{{ $image->image_url }}" alt="" class="rounded-[10px] h-[150px]">
            @endforeach
        @else
            <p class="text-gray-500">No images yet</p>
        @endif
    </div>
</div>
