@component("components.layout.appshell", [
    "title" => t("Devices"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        @if(!empty($device))
            {{ t("Edit device \$\$name\$\$", ["name" => $device->getName()]) }}
        @else
            {{ t("Create device") }}
        @endif
    </h1>

    <form method="post" action="{{ Router->generate("device-save") }}">
        @if(!empty($device))
            <input type="hidden" name="device" value="{{ $device->getId() }}">
        @endif

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="name" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Device name") }}
            </label>
            <input id="name"
                   name="name"
                   type="text"
                   class="{{ TailwindUtil::$input }}"
                   value="{{ !empty($device) ? $device->getName() : "" }}"
                   placeholder="{{ t("Device name") }}"
                   maxlength="256"
                   required>
        </div>

        @if(!empty($device))
            <div class="{{ TailwindUtil::inputGroup() }} mb-2">
                <label for="device-uid" class="{{ TailwindUtil::$inputLabel }}">
                    {{ t("Device UID") }}
                </label>
                <input id="device-uid"
                       name="device-uid"
                       type="text"
                       class="{{ TailwindUtil::$input }}"
                       value="{{ $device->getDeviceUid() }}"
                       readonly disabled>
            </div>

            <div class="{{ TailwindUtil::inputGroup() }} mb-2">
                <label for="device-api-key" class="{{ TailwindUtil::$inputLabel }}">
                    {{ t("Device API key") }}
                </label>
                <input id="device-api-key"
                       name="device-api-key"
                       type="text"
                       class="{{ TailwindUtil::$input }}"
                       value="{{ $device->getDeviceApiKey() }}"
                       readonly disabled>
            </div>
        @endif

        <button type="submit" class="{{ TailwindUtil::button() }} gap-2">
            @include("components.icons.buttonload")
            @include("components.icons.save")
            {{ t("Save") }}
        </button>

        @if(!empty($device))
            <button type="button"
                    id="delete-device"
                    class="{{ TailwindUtil::button(false, "danger") }} gap-2"
                    data-delete-href="{{ Router->generate("device-delete", ["device" => $device->getId()]) }}">
                @include("components.icons.buttonload")
                @include("components.icons.delete")
                {{ t("Delete") }}
            </button>
        @endif
    </form>

    @include("components.modals.defaultabort")
    <script type="module">
        import * as DevicesEdit from "{{ Router->staticFilePath("js/devices/edit.js") }}";
        DevicesEdit.init();
    </script>
@endcomponent
