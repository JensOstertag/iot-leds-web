@component("components.layout.appshell", [
    "title" => t("Control panel"),
    "breadcrumbs" => $breadcrumbs ?? []
])
    <h1 class="mb-2">
        {{ t("\$\$name\$\$", ["name" => $device->getName()]) }}
    </h1>

    <form method="post" action="{{ Router::generate("control-save") }}">
        <input type="hidden" name="device" value="{{ $device->getId() }}">

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <label for="animation" class="{{ TailwindUtil::$inputLabel }}" data-required>
                {{ t("Animation") }}
            </label>
            <select id="animation"
                   name="animation"
                   class="{{ TailwindUtil::$select }}">
                <option value="" disabled @if(empty($currentAnimation)) selected @endif>{{ t("Select an animation") }}</option>
                @foreach($animations as $animation)
                    <option value="{{ $animation->getId() }}" @if($currentAnimation == $animation->getId()) selected @endif>
                        {{ $animation->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="{{ TailwindUtil::inputGroup() }} mb-2">
            <input id="power"
                   name="power"
                   type="checkbox"
                   class="{{ TailwindUtil::$checkbox }}"
                   value="1"
                   @if($device->getDeviceAnimation()?->getPower()) checked @endif>
            <label for="power" class="{{ TailwindUtil::$inputLabel }}">
                {{ t("Power") }}
            </label>
        </div>

        <button type="submit" class="{{ TailwindUtil::button() }} gap-2">
            @include("components.icons.buttonload")
            @include("components.icons.save")
            {{ t("Save") }}
        </button>
    </form>
@endcomponent
