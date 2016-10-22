module Views.Auth exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Html.Events exposing (onClick, onInput)
import Auth.LoginForm as LoginForm exposing (Msg(..))


loginForm : String -> LoginForm.State -> Html LoginForm.Msg
loginForm loginUrl { email, password } =
    H.section [ A.class "login-form" ]
        [ H.h1 [] [ H.text "Log In" ]
        , H.input
            [ A.type' "text"
            , A.placeholder "Email address"
            , onInput SetEmail
            ]
            []
        , H.input
            [ A.type' "password"
            , A.placeholder "Password"
            , onInput SetPassword
            ]
            []
        , H.button
            [ A.class "submit"
            , onClick (Submit loginUrl)
            ]
            [ H.text "Log In" ]
        , H.a [ A.href "#" ] [ H.text "Forgot password?" ]
        ]
