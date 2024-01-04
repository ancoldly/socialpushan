<div class="h-max grid items-center w-full ml-[465px] gap-[20px] bg-gray-100 p-[20px] rounded-[10px]">
    <div>
        <h1 class="font-medium text-[18px]">Popular near you</h1>
        <p class="text-gray-500">Groups that people in your area are in</p>
    </div>

    <div class="grid grid-cols-2 gap-[20px]">
        @foreach ($allGroups as $allGroup)
            @if (Auth::user() && $allGroup->users->contains(Auth::user()))
            @else
                <div class="grid gap-[20px] bg-white rounded-[10px] p-[20px]">
                    <div class="flex justify-between place-items-center">
                        <img src="{{ $allGroup->avatar }}" alt="" class="rounded-full h-[100px] w-[100px]">

                        <div class="grid">
                            <form action="{{ route('groupDetails') }}" method="GET">
                                <input type="hidden" name="idGroup" value="{{ $allGroup->id }}">
                                <button type="submit" class="font-semibold">{{ $allGroup->name }}</button>
                            </form>

                            <p class="text-blue-500">Members: {{ $allGroup->users->count() }}</p>

                            <span class="text-[14px] text-gray-500">Admin: {{ $allGroup->createdBy->name }}</span>
                        </div>
                    </div>

                    <form action="{{ route('JoinGroup') }}" method="POST" class="w-full joinGroup-form">
                        @csrf
                        <input type="hidden" name="codeGroup" value="{{ $allGroup->code_group }}">
                        <button class="p-[10px] bg-gray-200 font-semibold rounded-[5px] w-full">Join group</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</div>
