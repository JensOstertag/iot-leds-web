@component("components.layout.appshell", [
    "title" => t("Account settings"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Account settings") }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include("dashboard.components.link", [
            "icon" => "components.icons.password",
            "href" => Router->generate("account-settings-change-password"),
            "title" => t("Change password"),
            "description" => t("Update your account password.")
        ])

        @include("dashboard.components.link", [
            "icon" => "components.icons.apikey",
            "href" => Router->generate("account-settings-api-key"),
            "title" => t("Personal API key"),
            "description" => t("Manage your personal API key.")
        ])
    </div>
@endcomponent
