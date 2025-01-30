@component("components.layout.appshell", [
    "title" => t("Control panel"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Control panel") }}
    </h1>

    <div class="overflow-x-auto">
        <table id="controls-table" class="stripe" data-table-ajax="{{ Router::generate("control-overview-table") }}">
            <thead>
                <tr>
                    <th>{{ t("Device name") }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents filled by controls/overview.js --}}
            </tbody>
        </table>
    </div>

    <script type="module">
        import * as ControlsOverview from "{{ Router::staticFilePath("js/controls/overview.js") }}";
        ControlsOverview.init({
            "Search...": "{{ t("Search...") }}",
            "Loading...": "{{ t("Loading...") }}",
            "No entries": "{{ t("No entries") }}",
            "Back": "{{ t("Back") }}",
            "Next": "{{ t("Next") }}"
        });
    </script>
@endcomponent
