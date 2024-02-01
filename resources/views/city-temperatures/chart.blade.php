<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Weather forecasts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                    <canvas id="chart"></canvas>

                    <script>
                        const cities = @json($cityTemperatures);

                        const datasets = cities.map(cityTemperature => {
                            return {
                                label: cityTemperature.city.name,
                                data: JSON.parse(cityTemperature.hourly).temperature_2m,
                                borderColor: getRandomColor(),
                                fill: false
                            };
                        });

                        const chart = new Chart("chart", {
                            type: "line",
                            data: {
                                labels: JSON.parse(cities[0].hourly).time,
                                datasets: datasets
                            },
                            options: {
                                legend: {
                                    display: true
                                }
                            }
                        });

                        function getRandomColor() {
                            const hexadecimal = "0123456789ABCDEF";

                            let color = "#";
                            for (let i = 0; i < 6; i++) {
                                color += hexadecimal[Math.floor(Math.random() * 16)];
                            }

                            return color;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
