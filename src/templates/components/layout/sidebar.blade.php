<ul>
    @component("components.layout.sidebarlistitem", [
        "href" => Router::generate("dashboard"),
    ])
        {{ t("Dashboard") }}
    @endcomponent

    @component("components.layout.sidebarlistitem", [
        "href" => Router::generate("control-overview"),
    ])
        {{ t("Control panel") }}
    @endcomponent

    @component("components.layout.sidebarlistitem", [
        "href" => Router::generate("animation-overview"),
    ])
        {{ t("Animations") }}
    @endcomponent

    @component("components.layout.sidebarlistitem", [
        "href" => Router::generate("device-overview"),
    ])
        {{ t("Devices") }}
    @endcomponent
</ul>
