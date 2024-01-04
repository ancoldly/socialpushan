@extends('admin.layout')

@section('content')
    <main class="grid gap-[20px] p-[20px]">
        <h1 class="font-medium">Admin Dashboard</h1>
        <div class="flex items-start gap-[20px]">
            <div class="grid gap-[20px] border-[2px] rounded-[10px] p-[20px]">
                <h1 class="uppercase text-blue-500 font-medium">Dashboard post</h1>

                <div>
                    <p>Total Posts: <span class="font-medium">{{ $totalPosts }}</span></p>
                    <p>Daily Posts: <span class="font-medium">{{ $dailyPosts }}</span></p>
                </div>

                <div class="h-[250px]">
                    <canvas id="dailyChart" class="h-full"></canvas>
                </div>
            </div>

            <div class="grid gap-[20px] border-[2px] rounded-[10px] p-[20px]">
                <h1 class="uppercase text-blue-500 font-medium">Dashboard user</h1>

                <div>
                    <p>Total User: <span class="font-medium">{{ $totalUser }}</span></p>
                    <p>Daily User: <span class="font-medium">{{ $dailyUser }}</span></p>
                </div>

                <div class="h-[250px]">
                    <canvas id="dailyChartUser" class="h-full"></canvas>
                </div>
            </div>
        </div>

        <div class="flex items-start gap-[20px]">
            <div class="grid gap-[20px] border-[2px] rounded-[10px] p-[20px]">
                <h1 class="uppercase text-blue-500 font-medium">Dashboard Group</h1>

                <div>
                    <p>Total Groups: <span class="font-medium">{{ $totalGroups }}</span></p>
                    <p>Daily Groups: <span class="font-medium">{{ $dailyGroups }}</span></p>
                </div>

                <div class="h-[250px]">
                    <canvas id="dailyChartGroup" class="h-full"></canvas>
                </div>
            </div>

            <div class="grid gap-[20px] border-[2px] rounded-[10px] p-[20px]">
                <h1 class="uppercase text-blue-500 font-medium">Dashboard Chat Group</h1>

                <div>
                    <p>Total Chat Group: <span class="font-medium">{{ $totalChatGroups }}</span></p>
                    <p>Daily Chat Group: <span class="font-medium">{{ $dailyChatGroups }}</span></p>
                </div>

                <div class="h-[250px]">
                    <canvas id="dailyChartChatGroup" class="h-full"></canvas>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function drawChart(ctx, labels, data, label, backgroundColor, borderColor) {
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        var ctxPost = document.getElementById('dailyChart').getContext('2d');
        var dailyPostCounts = @json($dailyPostCounts);
        var labels = Object.keys(dailyPostCounts);
        var data = Object.values(dailyPostCounts);

        var ctxUser = document.getElementById('dailyChartUser').getContext('2d');
        var dailyUserCounts = @json($dailyUserCounts);
        var labelUser = Object.keys(dailyUserCounts);
        var dataUser = Object.values(dailyUserCounts);

        var ctxGroup = document.getElementById('dailyChartGroup').getContext('2d');
        var dailyGroupCounts = @json($dailyGroupCounts);
        var labelGroup = Object.keys(dailyGroupCounts);
        var dataGroup = Object.values(dailyGroupCounts);

        var ctxChatGroup = document.getElementById('dailyChartChatGroup').getContext('2d');
        var dailyChatGroupCounts = @json($dailyChatGroupCounts);
        var labelChatGroup = Object.keys(dailyChatGroupCounts);
        var dataChatGroup = Object.values(dailyChatGroupCounts);

        drawChart(ctxPost, labels, data, 'Daily Post Counts', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        drawChart(ctxUser, labelUser, dataUser, 'Daily User Counts', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        drawChart(ctxGroup, labelGroup, dataGroup, 'Daily Group Counts', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        drawChart(ctxChatGroup, labelChatGroup, dataChatGroup, 'Daily Chat Group Counts', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
    </script>
@endsection
