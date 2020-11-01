<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
        <style>
            .frame{
                width: 100%;
                height: 100%;
                margin: 0 auto;
                border: 1px solid #aaa;
            }

            .header{
                padding:40px 10px;
                text-align: center;
                background: #eee;
                margin-bottom: 20px;
            }

            .container {
                overflow: hidden;
            }

            .nav {
                float: left;
                width: 150px;
                background: #333;
                color: #fff;
                margin-right: 50px;
            }
            .nav-list {
                list-style: none;
                margin: 0;
                padding: 10px 0;
            }
            .nav-item {
                margin: 4px 0;
            }
            .nav-link {
                display: block;
                text-decoration: none;
                padding: 4px 10px;
                color: #fff;
            }
            .nav-link:hover {
                background: #5457de;
            }

            .content {
                float: left;
                width: 600px;
            }

            .footer {
                text-align: center;
                border-top: 1px solid #aaa;
                margin: 20px 20px 0;
                font-size: 12px;
            }

        </style>
    </head>
    <body>
        <div class="">


            <!-- top menu -->
            <nav class="flex items-center justify-between flex-wrap bg-teal-400  p-6">
                <div class="flex items-center flex-no-shrink text-white mr-6">
                    <svg class="h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
                    <span class="font-semibold text-xl tracking-tight text-gray-900">서초여성가족플라자</span>
                </div>
                <div class="block lg:hidden">
                    <button class="flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white">
                        <svg class="h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                    </button>
                </div>
                <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                    <div class="text-sm lg:flex-grow">
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4">
                        Docs
                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4">
                        Examples
                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white">
                        Blog
                        </a>
                    </div>
                <div>
                    <a href="#" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0">Download</a>
                </div>
                </div>
            </nav>



            <!-- left menu -->
            <div class="container">

                <div class="nav">
                    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-6">
                        <div class="flex w-full max-w-xs p-4 bg-gray-800">
                            <ul class="flex flex-col w-full">
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 bg-gray-100">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Dashboard</span>
                                        <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">3</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <span class="flex font-medium text-sm text-gray-400 px-4 my-4 uppercase">Projects</span>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Manager</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Tasks</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Clients</span>
                                        <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-300 h-6 px-2 rounded-full ml-auto">1k</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-green-400">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Add new</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <span class="flex font-medium text-sm text-gray-400 px-4 my-4 uppercase">Account</span>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Profile</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Notifications</span>
                                        <span class="flex items-center justify-center text-sm text-red-500 font-semibold bg-red-300 h-6 px-2 rounded-full ml-auto">10</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-gray-500">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Settings</span>
                                    </a>
                                </li>
                                <li class="my-px">
                                    <a href="#"
                                       class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-500 hover:bg-gray-700">
                                        <span class="flex items-center justify-center text-lg text-red-400">
                                            <svg fill="none"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                            </svg>
                                        </span>
                                        <span class="ml-3">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="content">
                    <div class="bg-red-700">Wow Tailwind</div>
                    <ul>
                        <li><a href="./main">Main Page</a></li>
                        <li><a href="./hello">Hello Page</a></li>
                        <li><a href="./bye">Bye Page</a></li>
                    </ul>
                    @yield('content')
                    <pre>
                        dlsflsjfldsjfd
                        dfdfdfdfdasdfas
                        asdfsadfsadfdsafadsfsadf

                        sdfsadfdsafsadfdsafsadfsad


                        sadfsdfdsafdsafdsafdsa
                        dsafsadfsadfsadf
                    </pre>
                </div>
            </div>

            <div class="footer">
                <p class="copyright">&copy;copyright</p>
            </div>
        </div>
    </body>
</html>
