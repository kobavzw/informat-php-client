<?php

namespace Koba\Informat\Directories\Students\GetPhoto;

class Photo
{
    /** Unique identifier which identifies the photo. (GUID) */
    public string $id;

    /** 
     * Unique identifier for the student. 
     * Same as the studentId provided via the url.
     */
    public string $persoonId;

    /** Base64-encoded string representation of the photo. */
    public string $foto;
}