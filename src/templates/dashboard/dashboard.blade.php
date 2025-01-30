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
            "href" => Router::generate("account-settings"),
            "title" => t("Account settings"),
            "description" => t("Manage your personal information, security settings, and account preferences.")
        ])
    </div>

    <h2 class="mt-4 bg-2">
        {{ t("Animation management") }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.accountsettings",
            "href" => Router::generate("animation-overview"),
            "title" => t("Animations"),
            "description" => t("Create or edit your own custom animations.")
        ])

        @include("dashboard.components.link", [
            "icon" => "components.icons.accountsettings",
            "href" => Router::generate("device-overview"),
            "title" => t("Devices"),
            "description" => t("Register new devices which should be animated.")
        ])
    </div>

    <h2 class="mt-4 bg-2">
        {{ t("API access") }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.accountsettings",
            "href" => Router::generate("api-overview"),
            "title" => t("API keys"),
            "description" => t("Manage your API keys.")
        ])
    </div>

{{--    @auth(0)--}}
{{--        @include("dashboards.user")--}}
{{--    @endauth--}}
{{--    @auth(1)--}}
{{--        @include("dashboards.facilitator")--}}
{{--    @endauth--}}
{{--    @auth(2)--}}
{{--        @include("dashboards.admin")--}}
{{--    @endauth--}}
@endcomponent
