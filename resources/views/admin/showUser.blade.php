@extends('admin.layout')
@section('content')
    <main class="grid gap-[20px] p-[20px]">
        <form action="{{ route('admin.unverifiedUsers') }}" method="get">
            <button type="submit" class="font-medium text-blue-500">Unverified users</button>
        </form>

        <div class="p-[20px] rounded-[10px] border-[2px]">
            <table>
                <tr class="border-b-[2px]">
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">ID User</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Name</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Email</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Gender</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Avatar</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Biography</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Created at</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Active</td>
                </tr>

                @foreach ($users as $user)
                    @if ($user->role !== 'admin')
                        <tr class="p-[10px]">
                            <td class="py-[10px] px-[20px]">{{ $user->id }}</td>
                            <td class="py-[10px] px-[20px] font-medium">{{ $user->name }}</td>
                            <td class="py-[10px] px-[20px]">{{ $user->email }}</td>
                            <td class="py-[10px] px-[20px]">{{ $user->gender }}</td>
                            <td class="py-[10px] px-[20px]"> <img
                                    src="{{ $user->avatar ? $user->avatar : '/image/user.png' }}"
                                    class="w-[60px] h-[60px] rounded-full"> </td>
                            <td class="py-[10px] px-[20px]">{{ $user->biography }}</td>
                            <td class="py-[10px] px-[20px]">{{ $user->created_at }}</td>
                            <td class="py-[10px] px-[20px] text-red-500 font-medium text-center"><button
                                    onclick="adminDeleteUser({{ $user->id }})" id="admin-delete-user"><i class='bx bxs-trash text-[25px]' ></i></button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </main>
    <script src="/Script/admin.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection
