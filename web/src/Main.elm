module Main exposing (..)

import Html exposing (Html, section, div, text)
import Html.App
import Html.Attributes as A

import Views.Auth as Auth

type alias Model =
    Int


main : Program Never
main =
    Html.App.program
        { init = 0 ! []
        , view = view
        , update = \msg model -> 0 ! []
        , subscriptions = \_ -> Sub.none
        }


view : Model -> Html msg
view _ =
    section [ A.class "main"]
        [ Auth.loginForm ()

        ]
