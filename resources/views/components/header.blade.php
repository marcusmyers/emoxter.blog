<nav x-data="{ open: true }" class="bg-blue-900">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="w-full text-white p-4 justify-between">
            <div class="relative flex items-center h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="text-3xl font-weight-bold z-0 ml-4 hidden sm:block">
                    eMoxter
                </div>
                <div class="flex items-center hidden sm:block sm:ml-6 md:w-1/2">
                    <div class="flex">
                        <a href="/blog" class="px-3 py-2 rounded-md text-sm font-medium leading-5 text-white bg-blue-900 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Articles</a>
                        <!-- <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Team</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Projects</a>
                <a href="#" class="ml-4 px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Calendar</a> -->
                    </div>
                </div>
                <div class="z-40 sm:ml-10 sm:mt-10 mx-auto sm:inset-y-0 sm:right-0">
                    <img src="/img/mark_avatar.png" alt="Marks Profile Picture" class="rounded-full border-8 border-gray-100 h-32 w-32 mt-10">
                </div>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3">
            <a href="/blog" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 bg-blue-900 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Articles</a>
            <!-- <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Team</a>
            <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Projects</a>
            <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Calendar</a> -->
        </div>
    </div>
</nav>