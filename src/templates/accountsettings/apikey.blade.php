@component("components.layout.appshell", [
    "title" => t("Personal API key"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("Personal API key") }}
    </h1>

    <div class="{{ TailwindUtil::inputGroup() }} mb-2">
        <label for="personal-uid" class="{{ TailwindUtil::$inputLabel }}">
            {{ t("Personal UID") }}
        </label>
        <input id="personal-uid"
               name="personal-uid"
               type="text"
               class="{{ TailwindUtil::$input }}"
               value="{{ $user->getPersonalUid() }}"
               readonly disabled>
    </div>

    <div class="{{ TailwindUtil::inputGroup() }} mb-2">
        <label for="personal-api-key" class="{{ TailwindUtil::$inputLabel }}">
            {{ t("Personal API key") }}
        </label>
        <input id="personal-api-key"
               name="personal-api-key"
               type="text"
               class="{{ TailwindUtil::$input }}"
               value="{{ $user->getPersonalApiKey() }}"
               readonly disabled>
    </div>
@endcomponent
