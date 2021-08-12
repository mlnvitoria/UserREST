using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace NETCoreProject.Data.Validators
{
    public class DateOlderThanTodayAttribute : ValidationAttribute
    {
        public override bool IsValid(object value)
        {
            var dt = (DateTime)value;

            return (dt < DateTime.Today);
        }
    }
}
