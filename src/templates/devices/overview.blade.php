@component("components.layout.appshell", [
    "title" => t("Devices"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Devices") }}
    </h1>

    <a id="create-device"
       href="{{ Router->generate("device-create") }}"
       class="{{ TailwindUtil::button() }} gap-2">
        @include("components.icons.plus")
        {{ t("Create device") }}
    </a>

    <div class="overflow-x-auto">
        <table id="devices-table" class="stripe" data-table-ajax="{{ Router->generate("device-overview-table") }}">
            <thead>
                <tr>
                    <th>{{ t("Device name") }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents filled by devices/overview.js --}}
            </tbody>
        </table>
    </div>

    <script type="module">
        import * as DevicesOverview from "{{ Router->staticFilePath("js/devices/overview.js") }}";
        DevicesOverview.init({
            "Search...": "{{ t("Search...") }}",
            "Loading...": "{{ t("Loading...") }}",
            "No entries": "{{ t("No entries") }}",
            "Back": "{{ t("Back") }}",
            "Next": "{{ t("Next") }}"
        });
    </script>
@endcomponent
