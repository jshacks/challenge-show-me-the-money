module Views.Playground exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A
import Views.Admin as Admin
import Views.RegisterForm as Register


view =
    H.section [ A.class "main" ]
        [ Admin.addOrganization
        , Register.registerOrganization
        ]
