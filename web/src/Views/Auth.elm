module Views.Auth exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Html.Events exposing (onInput)


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


loginForm () =
    H.section [ A.class "login-form form-s" ]
        [ H.h2 [] [ H.text "Log In" ]
        , H.input [ A.type' "text", A.placeholder "Email address" ] []
        , H.input [ A.type' "password", A.placeholder "Password" ] []
        , H.button [ A.class "submit" ] [ H.text "Log In" ]
        , H.a [ A.href "#" ] [ H.text "Forgot password?" ]
        ]
