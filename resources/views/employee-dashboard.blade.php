<x-layout-component>
    <x-slot:title>Employee Dashboard</x-slot:title>

    <section class="py-6 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Welcome, Employee</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700">Attendance</h3>
                    <p class="text-sm text-gray-500 mt-2">Mark your attendance for the day.</p>
                    <a href="/mark-attendance" class="text-blue-500 mt-4 inline-block">Mark Attendance</a>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700">My Profile</h3>
                    <p class="text-sm text-gray-500 mt-2">Update and manage your profile information.</p>
                    <a href="/my-profile" class="text-blue-500 mt-4 inline-block">Edit Profile</a>
                </div>
            </div>
        </div>
    </section>
</x-layout-component>
