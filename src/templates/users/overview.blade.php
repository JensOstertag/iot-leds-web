@component("components.layout.appshell", [
    "title" => t("User management"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("User management") }}
    </h1>

    <a id="create-user"
       href="{{ Router::generate("user-create") }}"
       class="{{ TailwindUtil::button() }} gap-2">
        @include("components.icons.plus")
        {{ t("Create user") }}
    </a>

    <div class="overflow-x-auto">
        <table id="users-table" class="stripe" data-table-ajax="{{ Router::generate("user-overview-table") }}">
            <thead>
                <tr>
                    <th>{{ t("Username") }}</th>
                    <th>{{ t("Email") }}</th>
                    <th>{{ t("Email verified") }}</th>
                    <th>{{ t("Administrator") }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contents filled by users/overview.js --}}
            </tbody>
        </table>
    </div>

    <script type="module">
        import * as UsersOverview from "{{ Router::staticFilePath("js/users/overview.js") }}";
        UsersOverview.init({
            "Search...": "{{ t("Search...") }}",
            "Loading...": "{{ t("Loading...") }}",
            "No entries": "{{ t("No entries") }}",
            "Back": "{{ t("Back") }}",
            "Next": "{{ t("Next") }}"
        });
    </script>
@endcomponent
