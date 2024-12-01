<x-layout-component>
    <x-slot:title>Manager Dashboard</x-slot:title>

    <section class="py-6 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Welcome, Manager</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700">Employee Management</h3>
                    <p class="text-sm text-gray-500 mt-2">View, add, and manage employees in your department.</p>
                    <a href="/manage-employees" class="text-blue-500 mt-4 inline-block">Go to Employee Management</a>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700">Attendance Overview</h3>
                    <p class="text-sm text-gray-500 mt-2">Monitor and manage attendance records for your team.</p>
                    <a href="/attendance-overview" class="text-blue-500 mt-4 inline-block">View Attendance</a>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700">Reports</h3>
                    <p class="text-sm text-gray-500 mt-2">Generate detailed reports for employee performance.</p>
                    <a href="/generate-reports" class="text-blue-500 mt-4 inline-block">Generate Reports</a>
                </div>
            </div>
        </div>
    </section>
</x-layout-component>
