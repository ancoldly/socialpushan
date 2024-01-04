<div class="h-max grid items-center w-full ml-[465px] gap-[20px] bg-gray-100 p-[20px] rounded-[10px]">
    <div>
        <h1 class="font-medium text-[18px]">Popular near you</h1>
        <p class="text-gray-500">Groups that people in your area are in</p>
    </div>

    <div class="grid grid-cols-2 gap-[20px]">
        @foreach ($allGroups as $allGroup)
            @if (Auth::user() && $allGroup->users->contains(Auth::user()))
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

                    @if ($allGroup->created_by !== Auth::id())
                        <form class="deleteUserGroup-form" action="{{ route('deleteUserGroup') }}"
                            data-member-id="{{ $allGroup->members->where('user_id', Auth::id())->first()->id }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="member_id"
                                value="{{ $allGroup->members->where('user_id', Auth::id())->first()->id }}">
                            <button class="p-[10px] bg-gray-200 font-semibold rounded-[5px] w-full">Out group</button>
                        </form>
                    @else
                        <span class="text-blue-500">You are the admin.</span>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</div>
