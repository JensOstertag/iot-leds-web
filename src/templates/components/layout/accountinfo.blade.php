@auth
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 my-2">
        {{-- Account information --}}
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center shrink-0 w-12 h-12 bg-gray-light rounded-full">
                <svg class="w-2/3 h-2/3 fill-gray-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/>
                </svg>
            </div>

            <div class="flex flex-col break-all">
                <span class="text-gray text-sm">{{ t("Logged in as") }}</span>
                {{ Auth->getLoggedInUser()?->getUsername() }}
            </div>
        </div>

        {{-- Loguot button --}}
        <a class="{{ TailwindUtil::button(true) }} text-nowrap"
           href="{{ Router->generate("auth-logout") }}">
            {{ t("Log out") }}
        </a>
    </div>
@endauth
@guest
    <div class="flex items-center justify-end gap-4 my-2">
        {{-- Login button --}}
        <a class="text-primary hover:text-primary-effect cursor-pointer transition-all"
           href="{{ Router->generate("auth-login") }}">
            {{ t("Log in") }}
        </a>

        {{-- Register button --}}
        <a class="{{ TailwindUtil::button(true) }}"
           href="{{ Router->generate("auth-register") }}">
            {{ t("Register") }}
        </a>
    </div>
@endguest

