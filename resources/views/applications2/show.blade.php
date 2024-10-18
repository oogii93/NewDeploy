@if ($form)
    @include($formView, ['form' => $form])

@else
    <p>No form details available.</p>
@endif
