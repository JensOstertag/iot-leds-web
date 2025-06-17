@component("components.layout.appshell", [
    "title" => t("Animations"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Animations") }}
    </h1>

    <a id="create-animation"
       href="{{ Router->generate("animation-create") }}"
       class="{{ TailwindUtil::button() }} gap-2">
        @include("components.icons.plus")
        {{ t("Create animation") }}
    </a>

    <div class="overflow-x-auto">
        <table id="animations-table" class="stripe" data-table-ajax="{{ Router->generate("animation-overview-table") }}">
            <thead>
                <tr>
                    <th>{{ t("Animation name") }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents filled by animations/overview.js --}}
            </tbody>
        </table>
    </div>

    <script type="module">
        import * as AnimationsOverview from "{{ Router->staticFilePath("js/animations/overview.js") }}";
        AnimationsOverview.init({
            "Search...": "{{ t("Search...") }}",
            "Loading...": "{{ t("Loading...") }}",
            "No entries": "{{ t("No entries") }}",
            "Back": "{{ t("Back") }}",
            "Next": "{{ t("Next") }}"
        });
    </script>
@endcomponent
