//+build mage

package main

import (
	"fmt"
	"github.com/magefile/mage/sh"
)

var Default = Run

func Run() {
	fmt.Printf("running\n")
	s, _ := sh.Output("bash", "-c", "echo bla")
	fmt.Println(s)
}
