@component("components.layout.appshell", [
    "title" => t("Dashboard"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Dashboard") }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.accountsettings",
            "href" => Router->generate("account-settings"),
            "title" => t("Account settings"),
            "description" => t("Manage your personal information, security settings, and account preferences.")
        ])
    </div>

    <h2 class="mt-4 mb-2">
        {{ t("Control panel") }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.remote",
            "href" => Router->generate("control-overview"),
            "title" => t("Control panel"),
            "description" => t("Switch the animations for your devices.")
        ])
    </div>

    <h2 class="mt-4 mb-2">
        {{ t("Animation management") }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.animation",
            "href" => Router->generate("animation-overview"),
            "title" => t("Animations"),
            "description" => t("Create or edit your own custom animations.")
        ])

        @include("dashboard.components.link", [
            "icon" => "components.icons.device",
            "href" => Router->generate("device-overview"),
            "title" => t("Devices"),
            "description" => t("Register new devices which should be animated.")
        ])
    </div>

    @auth(PermissionLevel::ADMIN->value)
        <h2 class="mt-4 mb-2">
            {{ t("System administration") }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @include("dashboard.components.link", [
                "icon" => "components.icons.user",
                "href" => Router->generate("user-overview"),
                "title" => t("User management"),
                "description" => t("Manage user accounts.")
            ])

            @include("dashboard.components.link", [
                "icon" => "components.icons.gear",
                "href" => Router->generate("system-settings"),
                "title" => t("System settings"),
                "description" => t("Configure the system to your needs.")
            ])
        </div>
    @endauth
@endcomponent
