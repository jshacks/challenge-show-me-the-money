module Views.RegisterForm exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


registerOrganization =
    H.section [ A.class "register form-s" ]
        [ H.input [ A.disabled True, A.value "EmailGivenByAdmin@gmail.com" ] []
        , H.input [ A.type' "password", A.placeholder "Password" ] []
        , H.input [ A.type' "password", A.placeholder "Confirm password" ] []
        , H.button [ A.class "submit" ] [ H.text "Register" ]
        ]
